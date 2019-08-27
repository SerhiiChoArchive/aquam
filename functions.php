<?php declare(strict_types=1);

function get_cache_file_path(string $filename): string
{
    return __DIR__ . "/var/$filename";
}
