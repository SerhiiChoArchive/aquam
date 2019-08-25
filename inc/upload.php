<?php declare(strict_types=1);

use App\CsvHandler;
use App\Helper;

require_once __DIR__ . '/../vendor/autoload.php';

$file = Helper::getFileFromRequest($_FILES);
$file || Helper::redirect('../?msg=error');

if (!Helper::passwordIsCorrect($_POST)) {
    Helper::redirect('../?msg=error_pwd_wrong');
}

$file_data = new CsvHandler($file['tmp_name']);
$file_data->SaveData();

Helper::redirect('../?msg=success');
