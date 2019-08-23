<?php declare(strict_types=1);

use App\CsvHandler;
use App\Helper;

require_once '../vendor/autoload.php';

$file = Helper::getFileFromRequest($_FILES);

if (!$file) {
    header('Location: ../index.php');
    exit;
}

$file_data = new CsvHandler($file['tmp_name']);
dd($file_data->getAll());
