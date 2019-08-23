<?php declare(strict_types=1);

use App\DB;

require_once 'inc/main.php';

$result = (new DB)
    ->createTable()
    ->insertData()
    ->getAll();

header('Content-Type: application/json');

echo json_encode($result);
