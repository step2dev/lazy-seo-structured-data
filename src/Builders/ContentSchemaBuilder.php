<?php

namespace Step2dev\LazySeoStructuredData\Builders;

use Step2dev\LazySeoStructuredData\Support\SchemaCleaner;

final class ContentSchemaBuilder extends AbstractSchemaBuilder
{
    public function __construct(SchemaCleaner $cleaner, private readonly IdentitySchemaBuilder $identity)
    {
        parent::__construct($cleaner);
    }

    public function article(array $data = []): array
    {
        return $this->base($data['type'] ?? 'Article', [
            'headline' => $data['headline'] ?? $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
            'datePublished' => $data['date_published'] ?? $data['datePublished'] ?? null,
            'dateModified' => $data['date_modified'] ?? $data['dateModified'] ?? null,
            'author' => $this->identity->personOrOrganization($data['author'] ?? null),
            'publisher' => $this->embedded($this->identity->organization($data['publisher'] ?? [])),
            'mainEntityOfPage' => $data['url'] ?? request()->fullUrl(),
        ], $data, ['author', 'publisher', 'headline', 'title', 'date_published', 'date_modified']);
    }

    public function blogPosting(array $data = []): array
    {
        return $this->article(array_replace(['type' => 'BlogPosting'], $data));
    }

    public function faqPage(array $items = []): array
    {
        if (array_key_exists('items', $items)) {
            $items = $items['items'];
        }

        $questions = [];

        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $questions[] = $this->cleaner->clean([
                '@type' => 'Question',
                'name' => $item['question'] ?? $item['name'] ?? null,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['answer'] ?? $item['text'] ?? null,
                ],
            ]);
        }

        return $this->base('FAQPage', ['mainEntity' => $questions]);
    }

    public function recipe(array $data = []): array
    {
        return $this->base('Recipe', [
            'name' => $data['name'] ?? $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
            'author' => $this->identity->personOrOrganization($data['author'] ?? null),
            'datePublished' => $data['date_published'] ?? $data['datePublished'] ?? null,
            'prepTime' => $data['prep_time'] ?? $data['prepTime'] ?? null,
            'cookTime' => $data['cook_time'] ?? $data['cookTime'] ?? null,
            'totalTime' => $data['total_time'] ?? $data['totalTime'] ?? null,
            'recipeYield' => $data['recipe_yield'] ?? $data['recipeYield'] ?? null,
            'recipeIngredient' => $data['ingredients'] ?? $data['recipeIngredient'] ?? null,
            'recipeInstructions' => $data['instructions'] ?? $data['recipeInstructions'] ?? null,
        ], $data, ['title', 'author', 'date_published', 'prep_time', 'cook_time', 'total_time', 'recipe_yield', 'ingredients', 'instructions']);
    }
}
