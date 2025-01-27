<?php

namespace App\Console\Commands;

// use App\Jobs\FetchNewsArticles;
use Illuminate\Console\Command;
use App\Services\FetchNewsArticles;

class FetchNews extends Command
{
    protected $signature = 'fetch:news';
    protected $description = 'Fetch news articles from all providers';

    public function handle()
    {
        // $providers = ['newsapi', 'guardian', 'newYorkTimes'];
        $providers = ['newYorkTimes'];

        foreach ($providers as $provider) {
            $fetchNewsArticles = new FetchNewsArticles($provider);
            $fetchNewsArticles->handle();
            $this->info("Fetching news articles from {$provider}...");
        }
    }
}

