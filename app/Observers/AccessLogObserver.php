<?php

namespace App\Observers;

use App\Models\AccessLog;
use Illuminate\Support\Facades\Cache;

class AccessLogObserver
{
    public function created(AccessLog $accessLog)
    {
        Cache::forget('access_logs');
        Cache::forget('content_metrics');
    }

    public function updated(AccessLog $accessLog)
    {
        Cache::forget('access_logs');
        Cache::forget('content_metrics');
    }

    public function deleted(AccessLog $accessLog)
    {
        Cache::forget('access_logs');
        Cache::forget('content_metrics');
    }
}