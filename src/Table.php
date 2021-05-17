<?php

namespace Kzu\Normalizer;

Trait Table {
    /**
     * arrayOneLine
     * Get array multi-dimensionnel, return simple array.
     * Used for search optimization.
     */
    static public function arrayOneLine(?array $array, ?string $prefix = null): ?array {
        foreach ($array as $key => $value):
            if (is_array($value) || is_object($value)):
                $results[$prefix.$key] = $value;
                $results = array_merge($results ?? [], Table::arrayOneLine((array) $value, $prefix.$key.'.'));
            else:
                $results[$prefix.$key] = $value;
            endif;
        endforeach;
        return $results ?? [];
    }

    static public function getAllKeys(array $array): ?array {
        foreach ($array as $key => $value):
            if (is_array($value)): 
                $keys = array_merge($keys ?? [], [count($keys ?? []) => [$key => Table::getAllKeys($value)]]);
            else:
                $keys[] = $key;
            endif;
        endforeach;
        return $keys ?? [];
    }
}