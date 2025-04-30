<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanSeeder extends Seeder
{
    public function run()
    {
        DB::table('subscription_plans')->insert([
            ['name' => 'Basic', 'daily_article_limit' => 2],
            ['name' => 'Pro', 'daily_article_limit' => 5],
            ['name' => 'Premium', 'daily_article_limit' => 0]
        ]);
    }
}