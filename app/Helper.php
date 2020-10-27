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
}
