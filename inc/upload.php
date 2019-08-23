<?php declare(strict_types=1);

use App\CsvHandler;
use App\Helper;

require_once '../vendor/autoload.php';

$file = Helper::getFileFromRequest($_FILES);
$file || Helper::redirect('../index.php');

$file_data = new CsvHandler($file['tmp_name']);
dd($file_data->getAll());
