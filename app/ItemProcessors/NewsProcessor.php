<?php

namespace App\ItemProcessors;

use App\Models\News;
use Illuminate\Support\Str;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\ItemProcessorInterface;
use RoachPHP\Support\Configurable;

class NewsProcessor implements ItemProcessorInterface
{
    use Configurable;

    public function processItem(ItemInterface $item): ItemInterface
    {
        $title = $item->get('title');
        $slug = Str::slug($title);

        News::query()->updateOrCreate([
            'title' => $title,
        ], [
            'slug' => $slug,
            'content' => $item->get('content'),
            'original_url' => $item->get('original_url'),
            'image_url' => $item->get('image_url'),
            'rating' => random_int(1, 10),
        ]);

        return $item;
    }
}
