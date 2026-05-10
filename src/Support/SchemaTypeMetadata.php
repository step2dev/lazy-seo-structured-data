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

            'SearchAction' => [
                'type' => 'SearchAction',
                'schema_org' => 'https://schema.org/SearchAction',
                'rich_result' => false,
                'notes' => 'Embedded action commonly used as WebSite.potentialAction for site search.',
                'required' => [
                    'target',
                    'query-input',
                ],
                'recommended' => [
                    'target',
                    'query-input',
                ],
                'optional' => [
                    'name',
                ],
            ],

            'Brand' => [
                'type' => 'Brand',
                'schema_org' => 'https://schema.org/Brand',
                'rich_result' => false,
                'notes' => 'Embedded identity type commonly used inside Product.brand.',
                'required' => [],
                'recommended' => [
                    'name',
                    'url',
                    'logo',
                    'sameAs',
                ],
                'optional' => [
                    'description',
                    'slogan',
                ],
            ],

            'ImageObject' => [
                'type' => 'ImageObject',
                'schema_org' => 'https://schema.org/ImageObject',
                'rich_result' => false,
                'notes' => 'Embedded media type for page, article, recipe, product, and organization images.',
                'required' => [],
                'recommended' => [
                    'url',
                    'contentUrl',
                    'width',
                    'height',
                ],
                'optional' => [
                    'caption',
                    'representativeOfPage',
                    'thumbnail',
                ],
            ],

            'PostalAddress' => [
                'type' => 'PostalAddress',
                'schema_org' => 'https://schema.org/PostalAddress',
                'rich_result' => false,
                'notes' => 'Embedded address type for Organization, LocalBusiness, Person, and Place.',
                'required' => [],
                'recommended' => [
                    'streetAddress',
                    'addressLocality',
                    'addressRegion',
                    'postalCode',
                    'addressCountry',
                ],
                'optional' => [
                    'postOfficeBoxNumber',
                ],
            ],

            'ContactPoint' => [
                'type' => 'ContactPoint',
                'schema_org' => 'https://schema.org/ContactPoint',
                'rich_result' => false,
                'notes' => 'Embedded contact type for Organization and LocalBusiness support/sales contacts.',
                'required' => [],
                'recommended' => [
                    'telephone',
                    'contactType',
                    'email',
                    'areaServed',
                    'availableLanguage',
                ],
                'optional' => [
                    'contactOption',
                    'hoursAvailable',
                    'productSupported',
                ],
            ],

            'AggregateRating' => [
                'type' => 'AggregateRating',
                'schema_org' => 'https://schema.org/AggregateRating',
                'rich_result' => false,
                'notes' => 'Embedded rating summary commonly used inside Product, Recipe, LocalBusiness, and Review targets.',
                'required' => [],
                'recommended' => [
                    'ratingValue',
                    'reviewCount',
                    'ratingCount',
                    'bestRating',
                    'worstRating',
                ],
                'optional' => [],
            ],

            'Rating' => [
                'type' => 'Rating',
                'schema_org' => 'https://schema.org/Rating',
                'rich_result' => false,
                'notes' => 'Embedded single rating type commonly used inside Review.reviewRating.',
                'required' => [],
                'recommended' => [
                    'ratingValue',
                    'bestRating',
                    'worstRating',
                ],
                'optional' => [],
            ],

            'Review' => [
                'type' => 'Review',
                'schema_org' => 'https://schema.org/Review',
                'rich_result' => false,
                'notes' => 'Embedded review type commonly used inside Product, Recipe, and LocalBusiness.',
                'required' => [],
                'recommended' => [
                    'author',
                    'reviewRating',
                    'reviewBody',
                    'datePublished',
                ],
                'optional' => [
                    'name',
                    'publisher',
                    'itemReviewed',
                ],
            ],

            'Question' => [
                'type' => 'Question',
                'schema_org' => 'https://schema.org/Question',
                'rich_result' => false,
                'notes' => 'Embedded type commonly used inside FAQPage.mainEntity.',
                'required' => [
                    'name',
                    'acceptedAnswer',
                ],
                'recommended' => [
                    'acceptedAnswer.text',
                ],
                'optional' => [
                    'answerCount',
                    'suggestedAnswer',
                ],
            ],

            'Answer' => [
                'type' => 'Answer',
                'schema_org' => 'https://schema.org/Answer',
                'rich_result' => false,
                'notes' => 'Embedded type commonly used inside Question.acceptedAnswer.',
                'required' => [
                    'text',
                ],
                'recommended' => [
                    'text',
                ],
                'optional' => [
                    'url',
                    'dateCreated',
                    'author',
                ],
            ],

            'ListItem' => [
                'type' => 'ListItem',
                'schema_org' => 'https://schema.org/ListItem',
                'rich_result' => false,
                'notes' => 'Embedded type used inside BreadcrumbList and ItemList.',
                'required' => [],
                'recommended' => [
                    'position',
                    'name',
                    'item',
                    'url',
                ],
                'optional' => [
                    'nextItem',
                    'previousItem',
                ],
            ],

            'Place' => [
                'type' => 'Place',
                'schema_org' => 'https://schema.org/Place',
                'rich_result' => false,
                'notes' => 'Embedded location type commonly used inside Event.location.',
                'required' => [],
                'recommended' => [
                    'name',
                    'address',
                    'geo',
                    'url',
                ],
                'optional' => [
                    'telephone',
                    'hasMap',
                    'sameAs',
                ],
            ],

            'VirtualLocation' => [
                'type' => 'VirtualLocation',
                'schema_org' => 'https://schema.org/VirtualLocation',
                'rich_result' => false,
                'notes' => 'Embedded online location type commonly used for virtual Event.location.',
                'required' => [],
                'recommended' => [
                    'url',
                ],
                'optional' => [
                    'name',
                    'description',
                ],
            ],

            'GeoCoordinates' => [
                'type' => 'GeoCoordinates',
                'schema_org' => 'https://schema.org/GeoCoordinates',
                'rich_result' => false,
                'notes' => 'Embedded geographic coordinates type commonly used inside Place.geo or LocalBusiness.geo.',
                'required' => [],
                'recommended' => [
                    'latitude',
                    'longitude',
                ],
                'optional' => [
                    'elevation',
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
