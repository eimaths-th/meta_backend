<?php

namespace App\Http\Controllers;

use App\Models\FormManage;
use App\Models\OpeningClosingTime;
use Illuminate\Http\Request;
use App\Helpers\LogActivity;

class TimeController extends Controller
{
    //
    public function saveTimes(Request $request)
    {
        $request->validate([
            'opening_time'  => 'required',
            'closing_time'  => 'required',
            'route'         => 'required',
            'user_id'       => 'required',
            // 'comments'      => 'required',
        ]);

        $openingTime = $request->input('opening_time');
        $closingTime = $request->input('closing_time');
        $route = $request->input('route');
        $user_id = $request->input('user_id');
        $comments = $request->input('comments');

        $control = OpeningClosingTime::create([
            'user_id' => $user_id,
            'comments' => $comments,
            'route' => $route,
            'opening_time' => $openingTime,
            'closing_time' => $closingTime,
        ]);

        // บันทึก activity log — สร้าง form control
        LogActivity::modelEvent($control, 'form_control created', null, $control->toArray());

        return redirect(route('formsControl'));
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
        $controls = OpeningClosingTime::orderBy('id', 'desc')
            ->get()
            ->groupBy('route');
        $now = now();

        foreach ($controls as $route => $times) {
            // หาสนามใหม่ล่าสุด
            $latestTime = $times->first();

            // ตรวจสอบว่าสนามใหม่ล่าสุดปิดไปแล้วหรือยัง
            $closingDateTime = $now->copy()->setDateTimeFrom($latestTime->closing_time);

            if ($now > $closingDateTime) {
                // ถ้าสนามใหม่ล่าสุดปิดไปแล้ว ให้ทุกสนามของ route นี้เป็น Offline
                foreach ($times as $time) {
                    $time->update(['status' => 'Offline']);
                }
            } else {
                // ถ้ายังไม่ปิด ให้ตรวจสอบแต่ละสนามตามเวลาของสนามนั้นๆ
                foreach ($times as $time) {
                    $openingDateTime = $now->copy()->setDateTimeFrom($time->opening_time);
                    $closingDateTime = $now->copy()->setDateTimeFrom($time->closing_time);

                    if ($now < $openingDateTime || $now > $closingDateTime) {
                        $status = 'Offline';
                        $time->update(['status' => $status]);
                    } else {
                        $status = 'Online';
                        $time->update(['status' => $status]);
                    }
                }
            }
        }

        $control = OpeningClosingTime::orderBy('id', 'desc')
            ->get();
        return view('receipt_form.form_control', [
            'controls' => $control
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
