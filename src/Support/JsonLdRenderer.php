<?php

namespace Step2dev\LazySeoStructuredData\Support;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\HtmlString;

final class JsonLdRenderer
{
    public function __construct(
        private readonly SchemaCleaner $cleaner,
        private readonly JsonOptions $options,
    ) {}

    public function encode(array|Arrayable $schema): string
    {
        $json = json_encode($this->cleaner->clean($schema), $this->options->flags());

        return $json === false ? '{}' : $json;
    }

    public function render(array|Arrayable $schema): HtmlString
    {
        return new HtmlString('<script type="application/ld+json">'.$this->encode($schema).'</script>');
    }
}
