<?php

namespace Step2dev\LazySeoStructuredData\Support;

use InvalidArgumentException;

final class CustomSchemaRegistry
{
    /**
     * @var array<string, callable|class-string>
     */
    private array $builders = [];

    public function __construct(
        private readonly SchemaTypeNormalizer $normalizer,
    ) {}

    /**
     * @param callable|class-string $builder
     */
    public function register(string $type, callable|string $builder): void
    {
        $this->builders[$this->normalizer->normalize($type)] = $builder;
    }

    public function has(string $type): bool
    {
        return array_key_exists($this->normalizer->normalize($type), $this->builders);
    }

    public function make(string $type, array $data = []): array
    {
        $normalizedType = $this->normalizer->normalize($type);
        $builder = $this->builders[$normalizedType];

        if (is_string($builder)) {
            $builder = app($builder);
        }

        if (! is_callable($builder)) {
            throw new InvalidArgumentException("Custom structured data type [{$type}] must be callable or an invokable class.");
        }

        /** @var array $schema */
        $schema = $builder($data, $type);

        return $schema;
    }

    public function types(): array
    {
        return array_keys($this->builders);
    }
}
