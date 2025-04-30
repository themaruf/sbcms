<?php

namespace App\Observers;

use App\Models\Article;
use Illuminate\Support\Facades\Cache;

class ArticleObserver
{
    public function created(Article $article)
    {
        Cache::forget('articles');
        Cache::forget('content_metrics');
        Cache::forget("user_".$article->user_id."_articles");
    }

    public function updated(Article $article)
    {
        Cache::forget('articles');
        Cache::forget('content_metrics');
        Cache::forget("user_".$article->user_id."_articles");
    }

    public function deleted(Article $article)
    {
        Cache::forget('articles');
        Cache::forget('content_metrics');
        Cache::forget("user_".$article->user_id."_articles");
    }
}