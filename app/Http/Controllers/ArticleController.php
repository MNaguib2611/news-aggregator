<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArticleService;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Article API",
 *     version="1.0.0",
 *     description="API for managing articles"
 * )
 *
 * @OA\Schema(
 *     schema="Article",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="source", type="string"),
 *     @OA\Property(property="category", type="string"),
 *     @OA\Property(property="author", type="string"),
 *     @OA\Property(property="url", type="string"),
 *     @OA\Property(property="image_url", type="string"),
 *     @OA\Property(property="published_at", type="string", format="date-time"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * @OA\Get(
     *     path="/api/articles",
     *     summary="Get filtered articles",
     *     tags={"Articles"},
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Filter by category",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="author",
     *         in="query",
     *         description="Filter by author",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="source",
     *         in="query",
     *         description="Filter by source",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search in title or description",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of articles",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Article")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $filters = $request->only(['category', 'author', 'source', 'search']);
        $articles = $this->articleService->getFilteredArticles($filters);

        return response()->json($articles);
    }

    /**
     * @OA\Get(
     *     path="api/articles/filters",
     *     summary="Get filter values",
     *     tags={"Articles"},
     *     @OA\Response(
     *         response=200,
     *         description="Filter values",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="categories",
     *                 type="array",
     *                 @OA\Items(type="string")
     *             ),
     *             @OA\Property(
     *                 property="authors",
     *                 type="array",
     *                 @OA\Items(type="string")
     *             ),
     *             @OA\Property(
     *                 property="sources",
     *                 type="array",
     *                 @OA\Items(type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function getFilterValues()
    {
        $filters = $this->articleService->getFilterValues();

        return response()->json($filters);
    }
}
