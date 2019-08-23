<?php declare(strict_types=1);

use App\Helper;

require_once '../vendor/autoload.php';

$file = Helper::getFileFromRequest($_FILES);

if (!$file) {
    header('Location: ../index.php');
    exit;
}

$file = new SplFileObject($file['tmp_name']);
$result = [];

while (!$file->eof()) {
    $result[] = $file->fgetcsv();
}

dd($result);
