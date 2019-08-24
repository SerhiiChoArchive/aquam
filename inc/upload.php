<?php declare(strict_types=1);

use App\CsvHandler;
use App\Helper;

require_once __DIR__ . '/../vendor/autoload.php';

$file = Helper::getFileFromRequest($_FILES);
$file || Helper::redirect('../index.php?msg=error');

$file_data = new CsvHandler($file['tmp_name']);
$file_data->SaveData();

Helper::redirect('../?msg=success');