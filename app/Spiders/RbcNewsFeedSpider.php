<?php

namespace App\Spiders;

use App\ItemProcessors\NewsProcessor;
use Generator;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;
use Symfony\Component\DomCrawler\Crawler;

class RbcNewsFeedSpider extends BasicSpider
{
    protected const NEWS_ITEM_LIMIT = 15;

    public array $startUrls = [
        'https://www.rbc.ru/',
    ];

    public array $itemProcessors = [
        NewsProcessor::class
    ];

    /**
     * @param \RoachPHP\Http\Response $response
     *
     * @return Generator<ParseResult>
     */
    public function parse(Response $response): Generator
    {
        $newsBlockLinks = $response
            ->filterXPath('//*[@class="js-news-feed-list"]')
            ->children()
            ->filter('a.js-news-feed-item')
            ->filterXPath('//a[not(contains(@href, "utm"))]')
            ->filterXPath('//a[not(contains(@href, "video_id"))]')
            ->slice(length: self::NEWS_ITEM_LIMIT)
            ->links();

        foreach ($newsBlockLinks as $link) {
            yield $this->request('GET', $link->getUri(), 'parseNewsFeedItem');
        }
    }

    public function parseNewsFeedItem(Response $response): \Generator
    {
        $title = $response->filter('h1')->text();
        $content = $response->filter('.article__text')
            ->children('p')
            ->each(fn(Crawler $node) => $node->text());

        $imageUrl = $response->filterXPath('//div[@itemtype="https://schema.org/NewsArticle"]')
            ->children()
            ->filterXPath('//div[@itemprop="image"]')
            ->children()
            ->first()
            ->extract(['content'])[0];

        yield $this->item([
            'title' => $title,
            'content' => implode('', $content),
            'original_url' => $response->getUri(),
            'image_url' => $imageUrl,
        ]);
    }
}
