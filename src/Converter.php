<?php

namespace App;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

final class Converter
{
    /** @var string */
    private $xls_file_path;

    /** @var string */
    private $csv_file_path;

    public function __construct(string $xls_file_path)
    {
        $this->xls_file_path = $xls_file_path;
        $this->csv_file_path =$this->generateCsvFilename();
    }

    public function getCsvFilePath(): string
    {
        $spreadsheet = IOFactory::load($this->xls_file_path);

        $this->setHeaders();
        $this->saveFile($spreadsheet);

        return $this->csv_file_path;
    }

    private function setHeaders(): void
    {
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename={$this->csv_file_path}");
    }

    private function generateCsvFilename(): string
    {
        return get_cache_file_path(mt_rand(1, 99999) . '.csv');
    }

    private function saveFile(Spreadsheet $spreadsheet): void
    {
        $io_factory = IOFactory::createWriter($spreadsheet, 'Csv');
        $io_factory->save($this->csv_file_path);
    }
}
