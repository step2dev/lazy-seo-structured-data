<?php

namespace Step2dev\LazySeoStructuredData\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array make(string $type, array $data = [])
 * @method static string script(string $type, array $data = [])
 * @method static string toJson(array|\Illuminate\Contracts\Support\Arrayable $schema)
 */
class Schema extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'lazy-seo-structured-data.schema';
    }
}
