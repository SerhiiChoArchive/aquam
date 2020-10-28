<?php

declare(strict_types=1);

namespace App\Converters;

use App\ConversionResult;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use SplFileObject;

class XlsToArray
{
    use CanConvertToFish;
    use CanConvertToEquipment;
    use CanConvertToFeed;

    const NUMBER_OF_SHEETS_WE_NEED = 4;

    private string $pathname;
    private Xls $xls_reader;
    private ?array $images;
    private string $placeholder_image = 'https://i.ibb.co/9tpYXHz/fish-placeholder.jpg';

    public function __construct(string $pathname, Xls $xls_reader)
    {
        $this->pathname = $pathname;
        $this->xls_reader = $xls_reader;
        $this->images = $this->getImagesFromCSV();
    }

    /**
     * @return \App\ConversionResult
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \Exception
     */
    public function convert(): ConversionResult
    {
        $sheets = $this->getArrayFromSheet($this->xls_reader->load($this->pathname));

        return new ConversionResult(
            $this->convertToFish($sheets['fish']),
            $this->convertToEquipment($sheets['equipment']),
            $this->convertToFeed($sheets['feed']),
            [],
            []
        );
    }

    private function getImagesFromCSV(): ?array
    {
        $file_path = storage_path('app/csv/images.csv');

        if (!file_exists($file_path)) {
            return null;
        }

        $file = new SplFileObject($file_path);

        if (is_null($file)) {
            return null;
        }

        $result = [];

        while (!$file->eof()) {
            $csv = $file->fgetcsv();

            if (count($csv) !== 2) {
                continue;
            }

            $result[mb_strtolower(current($csv))] = last($csv);
        }

        return $result;
    }

    /**
     * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $sheets
     *
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function getArrayFromSheet(Spreadsheet $sheets): array
    {
        $categories = ['fish', 'equipment', 'feed', 'chemistry', 'aquariums'];

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

    private function getImageFrom(?string $name): ?string
    {
        $id = mb_strtolower(preg_replace('!\s+!', ' ', trim($name ?? '')));
        $id = preg_replace('/ /', '', $id);
        return $this->images[$id] ?? $this->placeholder_image;
    }

    private function getNotNulls(array $columns): array
    {
        return array_filter($columns, function ($item) {
            return !is_null($item) && $item !== '' && $item !== '0.00';
        });
}
}