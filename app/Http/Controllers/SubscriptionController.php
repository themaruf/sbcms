<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function show()
    {
        $subscription = Cache::remember('user_subscription_'.Auth::id(), 3600, function () {
            return Auth::user()->subscription()->with('plan')->firstOrFail();
        });
        return response()->json($subscription);
    }

    public function activate(Request $request)
    {
        $request->validate(['plan_id' => 'required|exists:subscription_plans,id']);

        $plan = SubscriptionPlan::find($request->plan_id);

        if (!$plan) {
            return response()->json(['message' => 'Subscription plan not found'], 404);
        }

        $activeSubscription = Auth::user()->subscription()->where('end_date', '>', now())->first();
        if ($activeSubscription && $activeSubscription->subscription_plan_id === $plan->id) {
            return response()->json(['message' => 'You already have an active subscription for this plan'], 409);
        }
        
        Auth::user()->subscription()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'subscription_plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => now()->addMonth()
            ]
        );

        Cache::forget('user_subscription_'.Auth::id());
        Cache::forget('content_metrics');
        Cache::forget("user_".Auth::id()."_articles");
        return response()->json(['message' => 'Subscription activated']);
    }
}