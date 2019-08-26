<?php declare(strict_types=1);

use App\Converter;
use App\Helper;
use App\CsvHandler;

require_once __DIR__ . '/../vendor/autoload.php';

$file = Helper::getFileFromRequest($_FILES);
$file || Helper::redirect('../?msg=error');

if (!Helper::passwordIsCorrect($_POST)) {
    Helper::redirect('../?msg=error_pwd_wrong');
}

$converter = new Converter($file['tmp_name']);
$file_data = new CsvHandler($converter->getCsvFilePath());
$file_data->saveData();

Helper::redirect('../?msg=success');
