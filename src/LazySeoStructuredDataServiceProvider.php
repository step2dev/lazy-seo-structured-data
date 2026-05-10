<?php

namespace Step2dev\LazySeoStructuredData;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Step2dev\LazySeoStructuredData\Builders\CommerceSchemaBuilder;
use Step2dev\LazySeoStructuredData\Commands\ListSchemaTypesCommand;
use Step2dev\LazySeoStructuredData\Builders\ContentSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\EventSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\IdentitySchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\ListSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\OfferSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\PageSchemaBuilder;
use Step2dev\LazySeoStructuredData\Services\JsonLdService;
use Step2dev\LazySeoStructuredData\Services\SchemaService;
use Step2dev\LazySeoStructuredData\Support\CustomSchemaRegistry;
use Step2dev\LazySeoStructuredData\Support\JsonLdRenderer;
use Step2dev\LazySeoStructuredData\Support\JsonOptions;
use Step2dev\LazySeoStructuredData\Support\SchemaCleaner;
use Step2dev\LazySeoStructuredData\Support\SchemaGraph;
use Step2dev\LazySeoStructuredData\Support\SchemaTypeNormalizer;
use Step2dev\LazySeoStructuredData\Support\SchemaTypeResolver;
use Step2dev\LazySeoStructuredData\View\Components\JsonLdComponent;

class LazySeoStructuredDataServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('lazy-seo-structured-data')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommand(ListSchemaTypesCommand::class);
    }

    public function packageRegistered(): void
    {
        foreach ([
            SchemaTypeNormalizer::class,
            SchemaCleaner::class,
            JsonOptions::class,
            CustomSchemaRegistry::class,
            JsonLdRenderer::class,
            SchemaGraph::class,
            SchemaTypeResolver::class,
            OfferSchemaBuilder::class,
            IdentitySchemaBuilder::class,
            ListSchemaBuilder::class,
            PageSchemaBuilder::class,
            ContentSchemaBuilder::class,
            CommerceSchemaBuilder::class,
            EventSchemaBuilder::class,
            SchemaService::class,
            JsonLdService::class,
        ] as $abstract) {
            $this->app->singleton($abstract);
        }

        $this->app->alias(SchemaService::class, 'lazy-seo-structured-data.schema');
        $this->app->alias(JsonLdService::class, 'lazy-seo-structured-data.jsonld');

        foreach (config('lazy-seo-structured-data.custom_types', []) as $type => $builder) {
            $this->app->make(SchemaService::class)->register($type, $builder);
        }
    }

    public function packageBooted(): void
    {
        if (! (bool) config('lazy-seo-structured-data.enabled', true)) {
            return;
        }

        Blade::component('lazy-seo-structured-data::json-ld', JsonLdComponent::class);
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
