<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ArticlePolicy
{
    public function view(User $user, Article $article)
    {
        // Admins can view everything
        if ($user->isAdmin()) {
            return true;
        }

        // Public articles are always accessible
        if ($article->type === 'public') {
            return true;
        }

        // Check active subscription
        $subscription = $user->subscription;
        if (!$subscription || $subscription->end_date < now()) {
            return false;
        }

        // Check daily limit using cached counter
        $cacheKey = 'user_'.$user->id.'_daily_views';
        $viewsToday = Cache::get($cacheKey, 0);

        if ($subscription->plan->daily_article_limit > 0 && $viewsToday >= $subscription->plan->daily_article_limit) {
            return false;
        }

        // Increment counter and log access
        Cache::put($cacheKey, $viewsToday + 1, now()->endOfDay());

        return true;
    }
}