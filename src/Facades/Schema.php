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
 * @method static array|null metadata(?string $type = null)
 * @method static array fields(string $type)
 * @method static array debug(string $type = 'WebPage', array $data = [])
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
 * @method static array offer(array $data = [])
 * @method static array searchAction(array|string $data = [])
 * @method static array brand(array|string $data = [])
 * @method static array imageObject(array|string $data = [])
 * @method static array postalAddress(array $data = [])
 * @method static array contactPoint(array $data = [])
 * @method static array aggregateRating(array $data = [])
 * @method static array rating(array $data = [])
 * @method static array review(array $data = [])
 * @method static array question(array $data = [])
 * @method static array answer(array|string|null $data = [])
 * @method static array listItem(array|string $data = [])
 * @method static array place(array|string $data = [])
 * @method static array virtualLocation(array|string $data = [])
 * @method static array geoCoordinates(array $data = [])
 */
class Schema extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'lazy-seo-structured-data.schema';
    }
}
