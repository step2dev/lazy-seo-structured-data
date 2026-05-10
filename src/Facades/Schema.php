<?php

namespace Step2dev\LazySeoStructuredData\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\HtmlString;

/**
 * @method static array make(string $type = 'webPage', array $data = [])
 * @method static array graph(array $schemas)
 * @method static HtmlString render(string $type = 'webPage', array $data = [])
 * @method static HtmlString renderGraph(array $schemas)
 * @method static HtmlString renderSchema(array|\Illuminate\Contracts\Support\Arrayable $schema)
 * @method static self register(string $type, callable|string $builder)
 * @method static array types()
 * @method static string toJson(array|\Illuminate\Contracts\Support\Arrayable $schema)
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
