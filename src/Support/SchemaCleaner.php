<?php

namespace Step2dev\LazySeoStructuredData\Support;

use Illuminate\Contracts\Support\Arrayable;

final class SchemaCleaner
{
    public function clean(array|Arrayable $data): array
    {
        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }

        foreach ($data as $key => $value) {
            if ($value instanceof Arrayable) {
                $value = $value->toArray();
            }

            if (is_array($value)) {
                $value = $this->clean($value);
            }

            if ($value === null || $value === '' || $value === []) {
                unset($data[$key]);
                continue;
            }

            $data[$key] = $value;
        }

        return $data;
    }
}
