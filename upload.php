<?php declare(strict_types=1);

require_once 'vendor/autoload.php';

$file = $_FILES['file'] ?? null;

if (!$file | empty($file['name'])) {
    header('Location: index.php');
    die();
}

$row = 1;
$result = [];

if (($handle = fopen($file['tmp_name'], 'r')) !== false) {
    
    while (($lines = fgetcsv($handle, 1000, ",")) !== false) {
        $num = count($lines);

        for ($i = 0; $i < $num; $i++) {
            if (!empty($lines[$i])) {
                $result[] = trim($lines[$i]);
            }
        }
    }
    fclose($handle);
}

dd($result);