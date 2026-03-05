<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SystemStatusController extends Controller
{
    public function index()
    {
        $urls = [
            'jQuery CDN' => 'https://code.jquery.com/jquery-3.5.1.js',
            'jQuery UI CDN' => 'https://code.jquery.com/ui/1.13.2/jquery-ui.js',
            'Toastr CDN' => 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js',
            'Bootstrap CDN' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js',
        ];

        $statuses = [];

        foreach ($urls as $name => $url) {
            $start = microtime(true);
            try {
                $response = Http::timeout(5)->get($url);
                $duration = round((microtime(true) - $start) * 1000, 2);

                $statuses[] = [
                    'name' => $name,
                    'url' => $url,
                    'status' => $response->successful() ? 'UP' : 'DOWN (' . $response->status() . ')',
                    'time' => $duration . ' ms',
                    'is_up' => $response->successful()
                ];
            } catch (\Exception $e) {
                $duration = round((microtime(true) - $start) * 1000, 2);
                $statuses[] = [
                    'name' => $name,
                    'url' => $url,
                    'status' => 'DOWN (' . $e->getMessage() . ')',
                    'time' => $duration . ' ms',
                    'is_up' => false
                ];
            }
        }

        return view('admin.system_status', compact('statuses'));
    }
}
