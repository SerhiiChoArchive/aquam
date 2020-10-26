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

        $categories = $this->getArrayFromSheet($sheets);

        $price_list = $this->convertToPriceList($categories['price-list']);

        return new ConversionResult($price_list, [], [], []);
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
        $categories = [
            ConversionResult::PRICE_LIST,
            ConversionResult::EQUIPMENT,
            ConversionResult::FEED,
            ConversionResult::CHEMISTRY,
        ];

        $result = [];

        for ($sheet_index = 0; $sheet_index < self::NUMBER_OF_SHEETS_WE_NEED; $sheet_index++) {
            $sheet = $sheets->getSheet($sheet_index);
            $index = 0;

            foreach ($sheet->getColumnIterator() as $column) {
                foreach ($column->getCellIterator() as $cell) {
                    $category = $categories[$sheet_index];
                    $result[$category][$index][] = $cell->getValue();
                }

                $index++;
            }
        }

        return $result;
    }

    /**
     * @param array $price_list
     *
     * @return array[]
     */
    private function convertToPriceList(array $price_list): array
    {
        $result = [];

        for ($i = 0; $i < count($price_list[0]); $i++) {
            $result[$i] = [
                'number' => $price_list[0][$i],
                'name' => $price_list[1][$i],
                'size' => $price_list[2][$i],
                'price' => $price_list[3][$i],
                'comment' => $price_list[4][$i],
                'order' => $price_list[5][$i],
                'sum' => $price_list[6][$i],
            ];

            $result[$i]['image'] = '';
        }

        dd($result);
        return $result;
    }
}