<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use App\Models\News;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\NewsCollection
     */
    public function index(): NewsCollection
    {
        return new NewsCollection(News::query()->paginate());
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\News $news
     *
     * @return \App\Http\Resources\NewsResource
     */
    public function show(News $news): NewsResource
    {
        return new NewsResource($news);
    }
}
