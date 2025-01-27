<?php

namespace App\Services;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Article;
use DateTime;

class FetchNewsArticles
{

    protected $provider;

    public function __construct($provider)
    {
        $this->provider = $provider;
    }

    public function handle()
    {
        Log::channel('daily')->info("Starting to fetch news articles from {$this->provider}");

        switch ($this->provider) {
            case 'newsapi':
                $this->fetchFromNewsAPI();
                break;
            case 'guardian':
                $this->fetchFromGuardian();
                break;
            case 'newYorkTimes':
                $this->fetchFromNewYorkTimes();
                break;

            default:
                Log::channel('daily')->error("Invalid provider: {$this->provider}");
                break;
        }

        Log::channel('daily')->info("Finished fetching news articles from {$this->provider}");
    }

    protected function fetchFromNewsAPI()
    {
        Log::channel('daily')->info("Fetching articles from NewsAPI");
        $categories = ['business', 'entertainment', 'general', 'health', 'science', 'sports', 'technology'];
        try {
            foreach ($categories as $category) {
                // Log::channel('daily')->info("Fetching category: {$category}");
                $response = Http::get('https://newsapi.org/v2/top-headlines', [
                    'pageSize' => 100,
                    'category' => $category,
                    'apiKey' => config('services.newsapi.key'),
                ]);

                $articles = $response->json()['articles'];

                foreach ($articles as $articleData) {
                    dump($articleData['content']);
                    if (Article::where('title', $articleData['title'])->exists() || empty($articleData['content'])) {
                        continue;
                    }
                    Article::create([
                        'title' => $articleData['title'],
                        'description' => $articleData['content'],
                        'source' => 'NewsAPI',
                        'category' => $category,
                        'url' => $articleData['url'],
                        'image_url' => $articleData['urlToImage'],
                        'published_at' => (new DateTime($articleData['publishedAt']))->format('Y-m-d H:i:s')
                    ]);
                }
            }
        } catch (\Exception $exception) {
            Log::channel('daily')->error("Error Fetching articles from NewsAPI: " . $exception->getMessage());
        }
    }

    protected function fetchFromGuardian()
    {
        Log::channel('daily')->info("Fetching articles from The Guardian");

        try {
            $response = Http::get('https://content.guardianapis.com/search', [
                'api-key' => config('services.guardian.key'),
                'show-fields' => 'trailText',
                'page-size' => 100,
                'order-by' => 'newest',
            ]);

            $articles = $response->json()['response']['results'];
            foreach ($articles as $articleData) {
                if (Article::where('title', $articleData['webTitle'])->exists()) {
                    continue;
                }

                Article::create([
                    'title' => $articleData['webTitle'],
                    'description' => $articleData['fields']['trailText'] ?? '', // Summary of the article
                    'source' => 'The Guardian',
                    'category' => $articleData['sectionName'],
                    'url' => $articleData['webUrl'],
                    'image_url' => $articleData['fields']['thumbnail'] ?? null, // Thumbnail image
                    'published_at' => (new DateTime($articleData['webPublicationDate']))->format('Y-m-d H:i:s'),
                ]);
            }
        } catch (\Exception $exception) {
            Log::channel('daily')->error("Error Fetching articles from The Guardian: " . $exception->getMessage());
        }
    }

    protected function fetchFromNewYorkTimes()
    {
        Log::channel('daily')->info("Fetching articles from The New York Times");

        try {
            $totalPages = 10;
            for ($page = 0; $page < $totalPages; $page++) {
                sleep(1); // Sleep 1 second before each request to avoid rate limiting

                $response = Http::get('https://api.nytimes.com/svc/search/v2/articlesearch.json', [
                    'api-key' => config('services.nytimes.key'),
                    'q' => '',
                    'sort' => 'newest',
                    'page' => $page
                ]);

                $articles = $response->json()['response']['docs'];

                foreach ($articles as $articleData) {
                    if (Article::where('title', $articleData['headline']['main'])->exists()) {
                        continue;
                    }

                    Article::create([
                        'title' => $articleData['headline']['main'],
                        'description' => $articleData['abstract'] ?? '',
                        'source' => 'The New York Times',
                        'url' => $articleData['web_url'],
                        'category' => $articleData['news_desk'],
                        'image_url' => $articleData['multimedia'][0]['url'] ?? null,
                        'published_at' => (new DateTime($articleData['pub_date']))->format('Y-m-d H:i:s'),
                    ]);
                }
            }
        } catch (\Exception $exception) {
            Log::channel('daily')->error("Error Fetching articles from The New York Times: " . $exception->getMessage());
        }
    }
}



