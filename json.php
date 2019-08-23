<?php declare(strict_types=1);

use App\DB;

require_once 'vendor/autoload.php';

define('DB_NAME', 'db/fish.db');

$result = (new DB)
    ->createTable()
    ->insertData()
    ->getAll();

header('Content-Type: application/json');

echo json_encode($result);
