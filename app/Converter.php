<?php

namespace App;

use PhpOffice\PhpSpreadsheet\IOFactory;

final class Converter
{
    /** @var string $file_path */
    private $file_path;

    public function __construct(string $file_path)
    {
        $this->file_path = $file_path;
    }

    public function getCsvFilePath(): string
    {
        $spreadsheet = IOFactory::load($_FILES['file']['tmp_name']);
        $rand = mt_rand(1, 10000);
        $filename = __DIR__ . "/../cache/$rand.csv";

        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename={$filename}");

        $io_factory = IOFactory::createWriter($spreadsheet, 'Csv');
        $io_factory->save("/{$filename}");
        // unlink($filename);

        return $filename;
    }
}
