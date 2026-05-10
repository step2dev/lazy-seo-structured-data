# Changelog

All notable changes to `lazy-seo-structured-data` will be documented in this file.

## v1.0.0 - unreleased

- Added clean public API: `Schema::make()`, `Schema::graph()`, `Schema::render()`, `Schema::renderGraph()`.
- Added JSON-LD graph rendering.
- Added custom schema registration via `Schema::register()` and `custom_types` config.
- Added `lazy-seo-structured-data:types` command.
- Added strict/fallback behavior for unknown schema types.
- Added recursive schema cleaning.
- Added grouped schema builders and support services.
- Added Blade component for JSON-LD rendering.
- Added lifecycle and rendering tests.
