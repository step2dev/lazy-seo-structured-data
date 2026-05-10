# Changelog

## Unreleased

- Added `Schema::debug()` for schema, JSON, metadata, and missing field inspection.
- Added `SearchAction` as a first-class Schema.org type and `Schema::searchAction()` helper method.
- Added common nested object types: `Brand`, `ImageObject`, `PostalAddress`, `ContactPoint`, `AggregateRating`, `Rating`, `Review`, `Question`, `Answer`, `ListItem`, `Place`, `VirtualLocation`, and `GeoCoordinates`.
- Added `NestedSchemaBuilder` for reusable embedded Schema.org objects.
- Improved Product, Event, Organization, LocalBusiness, WebSite, WebPage, CollectionPage, FAQPage, Article, BlogPosting, Recipe, and Offer builders with nested object normalization.
- Expanded schema type metadata with required, recommended, optional, rich result notes, and Schema.org URLs.
- Expanded README with typed examples for Article, Product, WebSite/SearchAction, Event, Virtual Event, Organization, FAQPage, and BreadcrumbList.

## Previous

- Removed legacy component aliases and deprecated JSON-LD APIs.
- Added schema field metadata and `lazy-seo-structured-data:types` command.
- Refactored schema builders, JSON-LD rendering, graph support, and public API.
