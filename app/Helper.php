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

    public static function getCategoriesDiff(array $categories1, array $categories2, string $column_to_compare): array
    {
        $names1 = self::getAllNames($categories1, $column_to_compare);
        $names2 = self::getAllNames($categories2, $column_to_compare);

        $diff = array_diff($names1, $names2) + array_diff($names2, $names1);

        $new_items1 = self::getDifferentItems($column_to_compare, $diff, $categories1);
        $new_items2 = self::getDifferentItems($column_to_compare, $diff, $categories2);

        return empty($new_items1) ? $new_items2 : $new_items1;
    }

    private static function getAllNames(array $categories, string $column_to_compare): array
    {
        $result = [];

        foreach ($categories as $category) {
            foreach ($category as $item) {
                if (mb_strlen($item[$column_to_compare]) > 0) {
                    $result[] = $item[$column_to_compare];
                }
            }
        }

        return $result;
    }

    private static function getDifferentItems(string $column_to_compare, array $diff, array $categories1): array
    {
        $different_items = array_map(function ($cat) use ($column_to_compare, $diff) {
             return array_filter($cat, fn($item) => in_array($item[$column_to_compare], $diff));
        }, $categories1);

        return array_filter($different_items, fn($item) => !empty($item));
    }
}
