<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>News Aggregator</title>
        <style>
            .news-container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
            }
            .news-item {
                background-color: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 20px;
                transition: transform 0.3s, box-shadow 0.3s;
            }
            .news-item:hover {
                transform: translateY(-5px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .news-title {
                font-size: 1.5rem;
                font-weight: bold;
                margin-bottom: 10px;
            }
            .news-description {
                font-size: 1.125rem;
            }
        </style>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="relative min-h-screen flex flex-col items-center justify-center">
                <h1 class="text-5xl font-bold mb-10">News Aggregator</h1>
                <div class="news-container">
                    <div class="news-item">
                        <div class="news-title">NewsAPI</div>
                        <div class="news-description">
                            This is a comprehensive API that allows developers to access articles from more than 70,000 news
                            sources, including major newspapers, magazines, and blogs. The API provides access to articles in various
                            languages and categories, and it supports search and filtering.
                        </div>
                    </div>
                    <div class="news-item">
                        <div class="news-title">OpenNews</div>
                        <div class="news-description">
                            This API provides access to a wide range of news content from various sources, including
                            newspapers, magazines, and blogs. It allows developers to retrieve articles based on keywords, categories,
                            and sources.
                        </div>
                    </div>
                    <div class="news-item">
                        <div class="news-title">NewsCred</div>
                        <div class="news-description">
                            The NewsCred API provides access to a wide range of news content from various sources, including
                            newspapers, magazines, and blogs. The API allows developers to retrieve articles based on keywords,
                            categories, and sources, as well as to search for articles by author, publication, and topic.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
