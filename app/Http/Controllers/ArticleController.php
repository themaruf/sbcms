<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\AccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::where('type', 'public')
            ->orderBy('publish_date', 'desc')
            ->paginate(10);
    }

    public function userArticles(Request $request)
    {
        $user = $request->user();
        
        return Cache::remember("user_{$user->id}_articles", 3600, function() use ($user) {
            $query = Article::query();
            $query->select('id', 'title', 'type', 'publish_date'); // hide content
            return $query->orderBy('publish_date', 'desc')->paginate(10);
        });
    }

    public function show(Article $article)
    {
        $this->authorize('view', $article);
        
        $user = request()->user();
        $cacheKey = 'user_'.$user->id.'_daily_views';

        if ($user->subscription->plan->daily_article_limit > 0 && Cache::get($cacheKey, 0) >= $user->subscription->plan->daily_article_limit) {
            return response()->json(['error' => 'Daily article limit exceeded'], 403);
        }

        Cache::increment($cacheKey);
        AccessLog::create([
            'user_id' => $user->id,
            'article_id' => $article->id,
            'accessed_at' => now()
        ]);

        return $article->load('accessLogs');
    }
}