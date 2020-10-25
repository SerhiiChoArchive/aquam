<?php

declare(strict_types=1);

namespace App;

use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class XlsToArrayConverter
{
    const NUMBER_OF_SHEETS_WE_NEED = 4;

    /**
     * @var string
     */
    private $pathname;

    /**
     * @var \PhpOffice\PhpSpreadsheet\Reader\Xls
     */
    private $xls_reader;

    public function __construct(string $pathname, Xls $xls_reader)
    {
        $this->pathname = $pathname;
        $this->xls_reader = $xls_reader;
    }

    /**
     * @return \App\ConversionResult
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function convert(): ConversionResult
    {
        $sheets = $this->getSpreadsheet();

        $array_from_sheets = $this->getArrayFromSheet($sheets);

        return $this->convertToConversionResult($array_from_sheets);
    }

    private function getSpreadsheet(): Spreadsheet
    {
        return $this->xls_reader->load($this->pathname);
    }

    /**
     * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $sheets
     *
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function getArrayFromSheet(Spreadsheet $sheets): array
    {
        $result = [];

        for ($sheet_index = 0; $sheet_index < self::NUMBER_OF_SHEETS_WE_NEED; $sheet_index++) {
            $sheet = $sheets->getSheet($sheet_index);

            foreach ($sheet->getColumnIterator() as $col_name => $col_value) {
                foreach ($col_value->getCellIterator() as $cell) {
                    $result[$sheet_index][$col_name][] = $cell->getValue();
                }
            }
        }

        return $result;
    }

    /**
     * @param array $sheets
     *
     * @return \App\ConversionResult
     */
    private function convertToConversionResult(array $sheets): ConversionResult
    {
        foreach ($sheets as $sheet) {

        }

        $price_list = [];
        $equipment = [];
        $feed = [];
        $chemistry = [];

        return new ConversionResult($price_list, $equipment, $feed, $chemistry);
    }
}