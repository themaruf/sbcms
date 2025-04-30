<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\AccessLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MetricsController extends Controller
{
    public function index()
    {
        $metrics = Cache::remember('content_metrics', 3600, function () {
            return [
                'top_articles' => Article::withCount('accessLogs')
                    ->orderBy('access_logs_count', 'desc')
                    ->take(5)
                    ->get(),
                'daily_access' => AccessLog::selectRaw('DATE(accessed_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date', 'desc')
                    ->take(30)
                    ->get(),
                'subscription_counts' => DB::table('subscriptions')
                    ->join('subscription_plans', 'subscriptions.subscription_plan_id', '=', 'subscription_plans.id')
                    ->select('subscription_plans.name', DB::raw('COUNT(*) as count'))
                    ->groupBy('subscription_plans.name')
                    ->get()
            ];
        });

        return response()->json($metrics);
    }
}