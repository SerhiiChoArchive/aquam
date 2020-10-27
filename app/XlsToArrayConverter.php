<?php

declare(strict_types=1);

namespace App;

use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use SplFileObject;

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

    /**
     * @var array|null
     */
    private $images;

    private $placeholder_image = 'https://i.ibb.co/9tpYXHz/fish-placeholder.jpg';

    public function __construct(string $pathname, Xls $xls_reader)
    {
        $this->pathname = $pathname;
        $this->xls_reader = $xls_reader;
        $this->images = $this->getImagesFromCSV();
    }

    /**
     * @return \App\ConversionResult
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function convert(): ConversionResult
    {
        $sheets = $this->xls_reader->load($this->pathname);

        $categories = $this->getArrayFromSheet($sheets);

        $fish = $this->convertToFish($categories['fish']);
        $equipment = $this->convertToEquipment($categories['equipment']);

        return new ConversionResult($fish, $equipment, [], []);
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

    /**
     * @param array $price_list
     *
     * @return array[]
     */
    private function convertToFish(array $price_list): array
    {
        $result = [];
        $title = '';

        for ($i = 3; $i < count($price_list[0]); $i++) {
            $columns = [
                'number' => $price_list[0][$i],
                'name' => $price_list[1][$i],
                'size' => $price_list[2][$i],
                'price' => $price_list[3][$i],
                'comment' => $price_list[4][$i] ?? '',
            ];

            $not_nulls = $this->getNotNulls($columns);

            if (empty($not_nulls)) {
                continue;
            }

            if (count($not_nulls) === 1) {
                if (is_object(current($not_nulls))) {
                    continue;
                }

                $title = current($not_nulls);
                continue;
            }

            $image = $this->getImageFrom($columns['name']);

            $result[$title][] = array_merge($columns, compact('image'));
        }

        return $result;
    }

    /**
     * @param array[] $equip
     *
     * @return array[]
     */
    private function convertToEquipment(array $equip): array
    {
        $result = [];
        $title = '';

        for ($i = 1; $i < count($equip[0]); $i++) {
            $article = $equip[0][$i] ?? '';

            $columns = [
                'article' => is_int($article) ? (string) $article : trim($article),
                'name' => $equip[1][$i],
                'description' => $equip[2][$i],
                'producer' => $equip[3][$i],
                'price' => $equip[4][$i],
            ];

            $not_nulls = $this->getNotNulls($columns);

            if (empty($not_nulls)) {
                continue;
            }

            if (count($not_nulls) === 1) {
                if (is_object(current($not_nulls))) {
                    continue;
                }

                $title = current($not_nulls);
                continue;
            }

            $image = $this->getImageFrom($columns['article']);

            $result[$title][] = array_merge($columns, compact('image'));
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