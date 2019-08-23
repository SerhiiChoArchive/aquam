<?php declare(strict_types=1);

namespace App;

final class Helper
{
    public static function getFileFromRequest(array $files): ?array
    {
        $file = $files['file'] ?? null;
        return $file && !empty($file['name']) ? $file : null;
    }
}