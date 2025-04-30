<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Admin user gets Premium plan
        $admin = User::where('email', 'admin@example.com')->first();
        $premiumPlan = SubscriptionPlan::where('name', 'Premium')->first();

        Subscription::create([
            'user_id' => $admin->id,
            'subscription_plan_id' => $premiumPlan->id,
            'start_date' => now(),
            'end_date' => now()->addYear()
        ]);

        // Regular user gets Basic plan
        $user = User::where('email', 'user@example.com')->first();
        $basicPlan = SubscriptionPlan::where('name', 'Basic')->first();

        Subscription::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $basicPlan->id,
            'start_date' => now(),
            'end_date' => now()->addMonth()
        ]);
    }
}