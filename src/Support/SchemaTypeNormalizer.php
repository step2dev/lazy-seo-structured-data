<?php

namespace Step2dev\LazySeoStructuredData\Support;

final class SchemaTypeNormalizer
{
    public function normalize(string $type): string
    {
        return str($type)->replace(['-', '_', ' '], '')->lower()->toString();
    }
}
