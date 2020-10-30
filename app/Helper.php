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
        $names1 = [];
        $names2 = [];

        foreach ($categories1 as $category)
            foreach ($category as $item)
                if (mb_strlen($item[$column_to_compare]) > 0)
                    $names1[] = $item[$column_to_compare];

        foreach ($categories2 as $category)
            foreach ($category as $item)
                if (mb_strlen($item[$column_to_compare]) > 0)
                    $names2[] = $item[$column_to_compare];

        $diff1 = array_diff($names1, $names2);
        $diff2 = array_diff($names2, $names1);
        $diff = array_merge($diff1, $diff2);

        $new_items1 = array_map(function ($cat) use ($diff, $column_to_compare) {
            return array_filter($cat, fn($item) => in_array($item[$column_to_compare], $diff));
        }, $categories1);

        $new_items2 = array_map(function ($cat) use ($diff, $column_to_compare) {
            return array_filter($cat, fn($item) => in_array($item[$column_to_compare], $diff));
        }, $categories2);

        $new_items1 = array_filter($new_items1, fn($item) => !empty($item));
        $new_items2 = array_filter($new_items2, fn($item) => !empty($item));

        return empty($new_items1) ? $new_items2 : $new_items1;
    }
}
