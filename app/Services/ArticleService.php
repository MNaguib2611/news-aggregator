<?php

namespace App\Services;

use App\Models\Article;

class ArticleService
{
    public function getFilteredArticles(array $filters)
    {
        $query = Article::query();

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['author'])) {
            $query->where('author', $filters['author']);
        }

        if (!empty($filters['source'])) {
            $query->where('source', $filters['source']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->get();
    }

    public function getFilterValues()
    {
        return [
            'categories' => Article::distinct()->pluck('category'),
            'authors' => Article::distinct()->pluck('author'),
            'sources' => Article::distinct()->pluck('source'),
        ];
    }
}
