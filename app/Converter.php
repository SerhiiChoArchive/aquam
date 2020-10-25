<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
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

    public function getCsvFilePath(): ?string
    {
        try {
            $spreadsheet = IOFactory::load($this->xls_file_path);

            $this->setHeaders();
            $this->saveFile($spreadsheet);

            return $this->csv_file_path;
        } catch (Exception | InvalidArgumentException $e) {
            logger()->error($e->getMessage());
        }
        return null;
    }

    private function setHeaders(): void
    {
        if (!app()->environment('testing')) {
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment; filename={$this->csv_file_path}");
        }
    }

    private function generateCsvFilename(): string
    {
        return storage_path(mt_rand(1, 99999) . '.csv');
    }

    private function saveFile(Spreadsheet $spreadsheet): void
    {
        $io_factory = IOFactory::createWriter($spreadsheet, 'Csv');
        $io_factory->save($this->csv_file_path);
    }
}
