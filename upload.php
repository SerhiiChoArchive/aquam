<?php declare(strict_types=1);

require_once 'vendor/autoload.php';

$file = $_FILES['file'] ?? null;

if (!$file | empty($file['name'])) {
    header('Location: index.php');
    die();
}

$file = new SplFileObject($file['tmp_name']);
$result = [];

while (!$file->eof()) {
    $result[] = $file->fgetcsv();
}

dd($result);
