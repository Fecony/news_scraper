<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PreviewNewsResource extends JsonResource
{
    protected const CONTENT_LENGTH_LIMIT = 200;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => Str::limit($this->content, self::CONTENT_LENGTH_LIMIT, ''),
            'rating' => $this->rating,
        ];
    }
}
