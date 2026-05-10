<?php

namespace Step2dev\LazySeoStructuredData;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Step2dev\LazySeoStructuredData\Builders\CommerceSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\ContentSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\EventSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\IdentitySchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\ListSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\OfferSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\PageSchemaBuilder;
use Step2dev\LazySeoStructuredData\Commands\ListSchemaTypesCommand;
use Step2dev\LazySeoStructuredData\Services\SchemaService;
use Step2dev\LazySeoStructuredData\Support\CustomSchemaRegistry;
use Step2dev\LazySeoStructuredData\Support\JsonLdRenderer;
use Step2dev\LazySeoStructuredData\Support\JsonOptions;
use Step2dev\LazySeoStructuredData\Support\SchemaCleaner;
use Step2dev\LazySeoStructuredData\Support\SchemaGraph;
use Step2dev\LazySeoStructuredData\Support\SchemaTypeMetadata;
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
            SchemaTypeMetadata::class,
            SchemaTypeResolver::class,
            OfferSchemaBuilder::class,
            IdentitySchemaBuilder::class,
            ListSchemaBuilder::class,
            PageSchemaBuilder::class,
            ContentSchemaBuilder::class,
            CommerceSchemaBuilder::class,
            EventSchemaBuilder::class,
            SchemaService::class,
        ] as $abstract) {
            $this->app->singleton($abstract);
        }

        $this->app->alias(SchemaService::class, 'lazy-seo-structured-data.schema');

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
    }
}
