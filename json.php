<?php declare(strict_types=1);

require_once 'vendor/autoload.php';

header('Content-Type: application/json');

echo file_get_contents('cache/fish.json');
