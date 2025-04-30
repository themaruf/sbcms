<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AccessLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = Cache::remember('access_logs', 3600, function () {
            return AccessLog::with('user','article')->latest()->take(100)->get();
        });

        return response()->json($logs);
    }
}