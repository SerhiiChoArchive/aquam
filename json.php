<?php declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\DB;

define('DB_NAME', 'db/fish.db');

$result = (new DB)
    ->createTable()
    ->insertData()
    ->getAll();

header('Content-Type: application/json');

echo json_encode($result);
