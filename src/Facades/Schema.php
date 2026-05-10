<?php

namespace Step2dev\LazySeoStructuredData\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array make(string $type = 'webPage', array $data = [])
 * @method static array graph(array $schemas)
 * @method static string toJson(array|\Illuminate\Contracts\Support\Arrayable $schema)
 * @method static string script(string $type = 'webPage', array $data = [])
 * @method static string scriptGraph(array $schemas)
 * @method static array webPage(array $data = [])
 * @method static array collectionPage(array $data = [])
 * @method static array article(array $data = [])
 * @method static array blogPosting(array $data = [])
 * @method static array product(array $data = [])
 * @method static array organization(array $data = [])
 * @method static array person(array $data = [])
 * @method static array localBusiness(array $data = [])
 * @method static array webSite(array $data = [])
 * @method static array breadcrumbList(array $items = [])
 * @method static array faqPage(array $items = [])
 * @method static array itemList(array $items = [])
 * @method static array event(array $data = [])
 * @method static array recipe(array $data = [])
 */
class Schema extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'lazy-seo-structured-data.schema';
    }
}
