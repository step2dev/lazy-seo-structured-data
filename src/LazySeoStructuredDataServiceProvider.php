<?php

namespace Step2dev\LazySeoStructuredData;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Step2dev\LazySeoStructuredData\Services\JsonLdService;
use Step2dev\LazySeoStructuredData\Services\SchemaService;
use Step2dev\LazySeoStructuredData\View\Components\JsonLdComponent;

class LazySeoStructuredDataServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('lazy-seo-structured-data')
            ->hasConfigFile()
            ->hasViews();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(SchemaService::class);
        $this->app->singleton(JsonLdService::class);
        $this->app->alias(SchemaService::class, 'lazy-seo-structured-data.schema');
        $this->app->alias(JsonLdService::class, 'lazy-seo-structured-data.jsonld');
    }

    public function packageBooted(): void
    {
        if (! (bool) config('lazy-seo-structured-data.enabled', true)) {
            return;
        }

        Blade::component('lazy-seo-structured-data-jsonld', JsonLdComponent::class);
        Blade::component('lazy-seo-structured-data-schema', JsonLdComponent::class);

        if ((bool) config('lazy-seo-structured-data.components.register_legacy_aliases', true)) {
            Blade::component('lazy-seo-jsonld', JsonLdComponent::class);
            Blade::component('lazy-seo-schema', JsonLdComponent::class);
            Blade::component('lazy-seo::json-ld', JsonLdComponent::class);
            Blade::component('lazy-seo::schema', JsonLdComponent::class);
        }
    }
}
