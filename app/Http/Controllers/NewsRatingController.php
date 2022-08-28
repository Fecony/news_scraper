<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatchNewsRatingRequest;
use App\Models\News;
use Illuminate\Http\JsonResponse;

class NewsRatingController extends Controller
{
    public function __invoke(PatchNewsRatingRequest $request, News $news): JsonResponse
    {
        return response()->json([
            'success' => $news->update([
                'rating' => $request->get('rating'),
            ]),
        ]);
    }
}
