<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'rating',
        'original_url',
        'image_url',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
