<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        
        // Create 15 articles with 3 premium
        Article::factory(12)->create([
            'type' => 'public',
            'title' => $faker->sentence,
            'content' => $faker->paragraphs(3, true)
        ]);
        
        Article::factory(3)->create([
            'type' => 'premium',
            'title' => $faker->sentence,
            'content' => $faker->paragraphs(5, true)
        ]);
        
        // Set publish dates within last month
        Article::all()->each(function ($article) use ($faker) {
            $article->update([
                'publish_date' => $faker->dateTimeBetween('-1 month', 'now')
            ]);
        });
    }
}