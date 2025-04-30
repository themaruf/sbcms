<?php

namespace App\Observers;

use App\Models\Subscription;
use Illuminate\Support\Facades\Cache;

class SubscriptionObserver
{
    public function updated(Subscription $subscription)
    {
        Cache::forget('user_subscription_'.$subscription->user_id);
        Cache::forget('content_metrics');
    }

    public function deleted(Subscription $subscription)
    {
        Cache::forget('user_subscription_'.$subscription->user_id);
        Cache::forget('content_metrics');
    }
}