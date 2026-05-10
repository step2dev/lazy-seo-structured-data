<?php

namespace Step2dev\LazySeoStructuredData\Builders;

final class ListSchemaBuilder extends AbstractSchemaBuilder
{
    public function breadcrumbList(array $items = []): array
    {
        if (array_key_exists('items', $items)) {
            $items = $items['items'];
        }

        $elements = [];

        foreach (array_values($items) as $index => $item) {
            $name = is_array($item) ? ($item['name'] ?? $item['title'] ?? '') : (string) $item;
            $url = is_array($item) ? ($item['url'] ?? $item['item'] ?? null) : null;
            $elements[] = $this->cleaner->clean([
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $name,
                'item' => $url,
            ]);
        }

        return $this->base('BreadcrumbList', ['itemListElement' => $elements]);
    }

    public function itemList(array $items = []): array
    {
        if (array_key_exists('items', $items)) {
            $items = $items['items'];
        }

        $elements = [];

        foreach (array_values($items) as $index => $item) {
            $elements[] = is_array($item)
                ? $this->cleaner->clean(array_replace(['@type' => 'ListItem', 'position' => $index + 1], $item))
                : ['@type' => 'ListItem', 'position' => $index + 1, 'name' => $item];
        }

        return $this->base('ItemList', ['itemListElement' => $elements]);
    }
}
