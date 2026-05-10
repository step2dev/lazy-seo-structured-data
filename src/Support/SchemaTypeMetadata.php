<?php

namespace Step2dev\LazySeoStructuredData\Support;

final class SchemaTypeMetadata
{
    public function __construct(
        private readonly SchemaTypeNormalizer $normalizer,
    ) {}

    /**
     * @return array<string, array{
     *     type: string,
     *     schema_org: string,
     *     rich_result: bool,
     *     notes: string|null,
     *     required: list<string>,
     *     recommended: list<string>,
     *     optional: list<string>
     * }>
     */
    public function all(): array
    {
        return [
            'Article' => [
                'type' => 'Article',
                'schema_org' => 'https://schema.org/Article',
                'rich_result' => true,
                'notes' => 'Schema.org type. Google Article rich results do not define required properties, but these fields are the practical SEO baseline.',
                'required' => [],
                'recommended' => [
                    'headline',
                    'description',
                    'image',
                    'datePublished',
                    'dateModified',
                    'author',
                    'publisher',
                    'mainEntityOfPage',
                ],
                'optional' => [
                    'articleBody',
                    'articleSection',
                    'keywords',
                    'wordCount',
                    'url',
                    'inLanguage',
                    'isAccessibleForFree',
                ],
            ],

            'BlogPosting' => [
                'type' => 'BlogPosting',
                'schema_org' => 'https://schema.org/BlogPosting',
                'rich_result' => true,
                'notes' => 'Subtype of Article. Uses the same practical SEO baseline as Article.',
                'required' => [],
                'recommended' => [
                    'headline',
                    'description',
                    'image',
                    'datePublished',
                    'dateModified',
                    'author',
                    'publisher',
                    'mainEntityOfPage',
                ],
                'optional' => [
                    'articleBody',
                    'articleSection',
                    'keywords',
                    'wordCount',
                    'url',
                    'inLanguage',
                    'commentCount',
                ],
            ],

            'FAQPage' => [
                'type' => 'FAQPage',
                'schema_org' => 'https://schema.org/FAQPage',
                'rich_result' => false,
                'notes' => 'Schema.org type. Google FAQ rich results are deprecated, but the type is still valid structured data.',
                'required' => [
                    'mainEntity',
                ],
                'recommended' => [
                    'mainEntity.name',
                    'mainEntity.acceptedAnswer',
                    'mainEntity.acceptedAnswer.text',
                ],
                'optional' => [
                    'name',
                    'description',
                    'url',
                    'inLanguage',
                ],
            ],

            'Recipe' => [
                'type' => 'Recipe',
                'schema_org' => 'https://schema.org/Recipe',
                'rich_result' => true,
                'notes' => 'Google Recipe rich results require a minimal set of properties for eligibility; add as many recommended fields as possible.',
                'required' => [
                    'name',
                    'image',
                ],
                'recommended' => [
                    'author',
                    'datePublished',
                    'description',
                    'prepTime',
                    'cookTime',
                    'totalTime',
                    'recipeYield',
                    'recipeCategory',
                    'recipeCuisine',
                    'recipeIngredient',
                    'recipeInstructions',
                    'nutrition',
                    'aggregateRating',
                    'video',
                ],
                'optional' => [
                    'keywords',
                    'suitableForDiet',
                    'estimatedCost',
                    'tool',
                    'supply',
                ],
            ],

            'Product' => [
                'type' => 'Product',
                'schema_org' => 'https://schema.org/Product',
                'rich_result' => true,
                'notes' => 'Product snippets require name. Merchant listing eligibility needs a stronger Offer and commerce-specific data.',
                'required' => [
                    'name',
                ],
                'recommended' => [
                    'image',
                    'description',
                    'sku',
                    'brand',
                    'offers',
                    'aggregateRating',
                    'review',
                ],
                'optional' => [
                    'gtin',
                    'gtin8',
                    'gtin12',
                    'gtin13',
                    'gtin14',
                    'mpn',
                    'category',
                    'color',
                    'material',
                    'size',
                    'weight',
                    'manufacturer',
                    'model',
                ],
            ],

            'Offer' => [
                'type' => 'Offer',
                'schema_org' => 'https://schema.org/Offer',
                'rich_result' => true,
                'notes' => 'Embedded commerce type commonly used inside Product and Event.',
                'required' => [
                    'price',
                    'priceCurrency',
                    'availability',
                    'url',
                ],
                'recommended' => [
                    'itemCondition',
                    'priceValidUntil',
                    'seller',
                ],
                'optional' => [
                    'shippingDetails',
                    'hasMerchantReturnPolicy',
                    'eligibleRegion',
                    'inventoryLevel',
                ],
            ],

            'Organization' => [
                'type' => 'Organization',
                'schema_org' => 'https://schema.org/Organization',
                'rich_result' => true,
                'notes' => 'Google Organization markup has no required fields, but name, url, logo, and sameAs are the useful baseline.',
                'required' => [],
                'recommended' => [
                    'name',
                    'url',
                    'logo',
                    'sameAs',
                ],
                'optional' => [
                    'alternateName',
                    'description',
                    'email',
                    'telephone',
                    'address',
                    'foundingDate',
                    'founder',
                    'contactPoint',
                    'brand',
                    'legalName',
                    'vatID',
                    'taxID',
                ],
            ],

            'Person' => [
                'type' => 'Person',
                'schema_org' => 'https://schema.org/Person',
                'rich_result' => false,
                'notes' => 'Useful as author, founder, performer, organizer, or profile entity.',
                'required' => [],
                'recommended' => [
                    'name',
                    'url',
                    'image',
                    'sameAs',
                    'jobTitle',
                ],
                'optional' => [
                    'description',
                    'worksFor',
                    'affiliation',
                    'email',
                    'telephone',
                    'address',
                    'knowsAbout',
                    'alumniOf',
                ],
            ],

            'LocalBusiness' => [
                'type' => 'LocalBusiness',
                'schema_org' => 'https://schema.org/LocalBusiness',
                'rich_result' => true,
                'notes' => 'Useful for local SEO. Address, telephone, opening hours, image, and geo data make it stronger.',
                'required' => [],
                'recommended' => [
                    'name',
                    'image',
                    'url',
                    'telephone',
                    'address',
                    'openingHoursSpecification',
                    'priceRange',
                ],
                'optional' => [
                    'description',
                    'geo',
                    'sameAs',
                    'email',
                    'logo',
                    'aggregateRating',
                    'review',
                    'hasMap',
                    'paymentAccepted',
                    'currenciesAccepted',
                ],
            ],

            'BreadcrumbList' => [
                'type' => 'BreadcrumbList',
                'schema_org' => 'https://schema.org/BreadcrumbList',
                'rich_result' => true,
                'notes' => 'Used for breadcrumb rich results. itemListElement should contain ListItem entries with position, name, and item.',
                'required' => [
                    'itemListElement',
                ],
                'recommended' => [
                    'itemListElement.position',
                    'itemListElement.name',
                    'itemListElement.item',
                ],
                'optional' => [
                    'name',
                    'description',
                    'numberOfItems',
                ],
            ],

            'ItemList' => [
                'type' => 'ItemList',
                'schema_org' => 'https://schema.org/ItemList',
                'rich_result' => false,
                'notes' => 'Useful for collection pages, lists, category pages, and @graph relationships.',
                'required' => [
                    'itemListElement',
                ],
                'recommended' => [
                    'itemListElement.position',
                    'itemListElement.name',
                    'itemListElement.url',
                ],
                'optional' => [
                    'name',
                    'description',
                    'numberOfItems',
                    'itemListOrder',
                ],
            ],

            'Event' => [
                'type' => 'Event',
                'schema_org' => 'https://schema.org/Event',
                'rich_result' => true,
                'notes' => 'Google Event rich results require name, startDate, and location for eligibility.',
                'required' => [
                    'name',
                    'startDate',
                    'location',
                ],
                'recommended' => [
                    'description',
                    'image',
                    'endDate',
                    'eventStatus',
                    'eventAttendanceMode',
                    'offers',
                    'performer',
                    'organizer',
                ],
                'optional' => [
                    'doorTime',
                    'duration',
                    'previousStartDate',
                    'typicalAgeRange',
                    'maximumAttendeeCapacity',
                    'remainingAttendeeCapacity',
                ],
            ],

            'WebSite' => [
                'type' => 'WebSite',
                'schema_org' => 'https://schema.org/WebSite',
                'rich_result' => true,
                'notes' => 'Useful for site identity and sitelinks search box when potentialAction is present.',
                'required' => [],
                'recommended' => [
                    'name',
                    'url',
                    'potentialAction',
                ],
                'optional' => [
                    'description',
                    'publisher',
                    'inLanguage',
                    'sameAs',
                    'alternateName',
                ],
            ],

            'WebPage' => [
                'type' => 'WebPage',
                'schema_org' => 'https://schema.org/WebPage',
                'rich_result' => false,
                'notes' => 'Base page entity. Use it for generic pages and as part of @graph.',
                'required' => [],
                'recommended' => [
                    'name',
                    'description',
                    'url',
                    'inLanguage',
                    'isPartOf',
                    'breadcrumb',
                ],
                'optional' => [
                    'primaryImageOfPage',
                    'datePublished',
                    'dateModified',
                    'author',
                    'publisher',
                    'mainEntity',
                ],
            ],

            'CollectionPage' => [
                'type' => 'CollectionPage',
                'schema_org' => 'https://schema.org/CollectionPage',
                'rich_result' => false,
                'notes' => 'Subtype of WebPage. Good for category, listing, archive, and search result pages.',
                'required' => [],
                'recommended' => [
                    'name',
                    'description',
                    'url',
                    'mainEntity',
                    'breadcrumb',
                ],
                'optional' => [
                    'inLanguage',
                    'isPartOf',
                    'datePublished',
                    'dateModified',
                    'hasPart',
                    'about',
                ],
            ],
        ];
    }

    /**
     * @return array{
     *     type: string,
     *     schema_org: string,
     *     rich_result: bool,
     *     notes: string|null,
     *     required: list<string>,
     *     recommended: list<string>,
     *     optional: list<string>
     * }|null
     */
    public function for(string $type): ?array
    {
        $normalizedType = $this->normalizer->normalize($type);

        foreach ($this->all() as $schemaType => $metadata) {
            if ($this->normalizer->normalize($schemaType) === $normalizedType) {
                return $metadata;
            }
        }

        return null;
    }

    /**
     * @return list<string>
     */
    public function typeNames(): array
    {
        return array_keys($this->all());
    }
}
