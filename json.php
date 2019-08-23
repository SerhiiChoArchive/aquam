<?php declare(strict_types=1);

require_once 'vendor/autoload.php';

header('Content-Type: application/json');

$content = @file_get_contents('cache/fish');

echo $content ? $content : json_encode(['status' => 404, 'data' => null]);
