<?php

declare(strict_types=1);

/**
 * @param array $routes
 * @return string
 */
function active_if_route_is(array $routes): string
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
