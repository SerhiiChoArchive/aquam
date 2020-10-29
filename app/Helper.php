<?php

declare(strict_types=1);

namespace App;

class Helper
{
    public static function activeIfRouteIs(array $routes): string
    {
        foreach ($routes as $route) {
            $route_starts_with_slash = $route[0] == '/' && strlen($route) != 1;
            $given_request = $route_starts_with_slash ? substr($route, 1) : $route;

            if (request()->is($given_request)) {
                return 'active';
            }
        }

        return '';
    }

    /**
     * @param array[] $arr
     *
     * @return int
     */
    public static function countArrayItems(?array $arr): int
    {
        return array_reduce($arr ?? [], function ($carry, $item) {
            return $carry + count($item);
        }, 0);
    }

    public static function arrayDiffRecursive(array $arr1, array $arr2): array
    {
        $result = [];

        foreach ($arr1 as $key => $value) {
            if (!array_key_exists($key, $arr2)) {
                $result[$key] = $value;
                continue;
            }

            if (is_array($value)) {
                $recursive_diff = self::arrayDiffRecursive($value, $arr2[$key]);

                if (count($recursive_diff) > 0) {
                    $result[$key] = $recursive_diff;
                }

                continue;
            }

            if ($value !== $arr2[$key]) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
