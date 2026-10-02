<?php

namespace App\Http\Controllers;

use App\Models\FormManage;
use App\Models\OpeningClosingTime;
use Illuminate\Http\Request;
use App\Helpers\LogActivity;
use App\Http\Middleware\EnsureCanManageForms;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

class TimeController extends Controller
{
    public function __construct()
    {
        $this->middleware(EnsureCanManageForms::class)->except('formsControl');
    }

    public function saveTimes(Request $request)
    {
        $validated = $request->validate([
            'opening_time' => ['required', 'date'],
            'closing_time' => ['required', 'date', 'after_or_equal:opening_time'],
            'route' => ['required', 'string', 'max:255'],
            'comments' => ['nullable', 'string'],
        ], [
            'opening_time.date' => 'Enter a valid opening date and time.',
            'closing_time.date' => 'Enter a valid closing date and time.',
            'closing_time.after_or_equal' => 'Closing time must be on or after opening time.',
        ]);

        $control = OpeningClosingTime::create([
            'user_id' => $request->user()->id,
            'comments' => $validated['comments'] ?? null,
            'route' => $validated['route'],
            'opening_time' => Carbon::parse($validated['opening_time'])->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s'),
            'closing_time' => Carbon::parse($validated['closing_time'])->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s'),
        ]);

        // บันทึก activity log — สร้าง form control
        LogActivity::modelEvent($control, 'form_control created', null, $control->toArray());

        if ($request->expectsJson()) {
            return response()->json(['redirect' => route('formsControl')]);
        }

        return redirect(route('formsControl'))->with('success', 'Registration schedule saved.');
    }
    public function formsTimes()
    {
        $formRoutes = FormManage::whereNotNull('slug')
            ->orderBy('form_name')
            ->get(['id', 'form_name', 'slug']);

        return view('route_control', [
            'formRoutes' => $formRoutes
        ]);
    }
    public function formsControl()
    {
        // The public registration page uses the most recently created schedule.
        $schedules = OpeningClosingTime::latestFirst()->get()->groupBy('route');
        $forms = FormManage::get(['id', 'form_name', 'slug', 'form_route', 'sfield']);
        $bySlug = $forms->filter(fn ($form) => filled($form->slug))->keyBy('slug');
        $byRoute = $forms->filter(fn ($form) => filled($form->form_route))->keyBy('form_route');
        $now = now();

        $entries = $schedules->map(function ($times, $route) use ($bySlug, $byRoute, $now) {
            $current = $times->first();
            $form = $bySlug->get($route) ?? $byRoute->get($route);
            $opening = Carbon::parse($current->opening_time);
            $closing = Carbon::parse($current->closing_time);
            $state = $now->lt($opening) ? 'upcoming' : ($now->gt($closing) ? 'closed' : 'open');
            $publicUrl = null;

            if ($form && $form->slug === (string) $route) {
                $publicUrl = route('form.show', ['slug' => $form->slug]);
            } elseif (Route::has($route) && empty(Route::getRoutes()->getByName($route)->parameterNames())) {
                $publicUrl = route($route);
            }

            return [
                'route' => (string) $route,
                'form' => $form,
                'name' => $form->form_name ?? $route,
                'opening' => $opening,
                'closing' => $closing,
                'state' => $state,
                'public_url' => $publicUrl,
                'comments' => $current->comments,
                'history' => $times->skip(1),
            ];
        })->sortBy(function ($entry) {
            $priority = ['open' => 0, 'upcoming' => 1, 'closed' => 2];
            $date = $entry['state'] === 'upcoming' ? $entry['opening'] : $entry['closing'];
            return [$priority[$entry['state']], $entry['state'] === 'closed' ? -$date->timestamp : $date->timestamp];
        })->values();

        return view('receipt_form.form_control', [
            'entries' => $entries,
            'canManageForms' => auth()->user()->canManageForms(),
        ]);
    }

    public function deleteControl($id)
    {
        $control = OpeningClosingTime::find($id);

        // บันทึก activity log — ลบ form control
        if ($control) {
            LogActivity::modelEvent($control, 'form_control deleted', $control->toArray(), null);
        }

        $control->delete();
        return redirect()->back()->with('error', 'Control deleted successfully!');
    }
}
