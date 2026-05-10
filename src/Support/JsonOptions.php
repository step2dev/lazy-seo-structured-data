<?php

namespace Step2dev\LazySeoStructuredData\Support;

final class JsonOptions
{
    public function flags(): int
    {
        $flags = 0;

        if ((bool) config('lazy-seo-structured-data.json.pretty', true)) {
            $flags |= JSON_PRETTY_PRINT;
        }

        if ((bool) config('lazy-seo-structured-data.json.unescaped_unicode', true)) {
            $flags |= JSON_UNESCAPED_UNICODE;
        }

        if ((bool) config('lazy-seo-structured-data.json.unescaped_slashes', true)) {
            $flags |= JSON_UNESCAPED_SLASHES;
        }

        return $flags;
    }
}
