<?php

declare(strict_types=1);

namespace App\Converters;

use App\ConversionResult;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use SplFileObject;

abstract class XlsToArray
{
    use CanConvertToFish;

    protected const NUMBER_OF_SHEETS_WE_NEED = 5;

    protected string $pathname;
    protected Xlsx $xlsx_reader;
    protected ?array $images;
    protected string $placeholder_image = 'https://i.ibb.co/9tpYXHz/fish-placeholder.jpg';

    public function __construct(string $pathname, Xlsx $xlsx_reader)
    {
        $this->pathname = $pathname;
        $this->xlsx_reader = $xlsx_reader;
        $this->images = [
            'fish' => $this->getImagesFromCSV('fish'),
            'equipment' => $this->getImagesFromCSV('equipment'),
            'feed' => $this->getImagesFromCSV('feed'),
            'chemistry' => $this->getImagesFromCSV('chemistry'),
            'aquariums' => $this->getImagesFromCSV('aquariums'),
        ];
    }

    /**
     * @return \App\ConversionResult
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \Exception
     */
    public function convert(): ConversionResult
    {
        $sheets = $this->getArrayFromSheet($this->xlsx_reader->load($this->pathname));

        return new ConversionResult(
            $this->convertToFish($sheets['fish']),
            $this->convertTo($sheets['equipment'], ['name', 'description', 'producer', 'price'], 'equipment'),
            $this->convertTo($sheets['feed'], ['name', 'description', 'weight', 'price'], 'feed'),
            $this->convertTo($sheets['chemistry'], ['name', 'capacity', 'description', 'price'], 'chemistry'),
            $this->convertTo($sheets['aquariums'], ['name', 'capacity', 'description', 'price'], 'aquariums'),
        );
    }

    protected function getImagesFromCSV(string $file_name): ?array
    {
        $file_path = storage_path("app/csv/$file_name.csv");

        if (!file_exists($file_path)) {
            return null;
        }

        $file = new SplFileObject($file_path);

        if (is_null($file)) {
            return null;
        }

        $result = [];

        while (!$file->eof()) {
            $csv = $file->fgetcsv('|');

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
    protected function getArrayFromSheet(Spreadsheet $sheets): array
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

    protected function getImageFrom(?string $name, string $images_category): ?string
    {
        $id = mb_strtolower(preg_replace('!\s+!', ' ', trim($name ?? '')));
        return $this->images[$images_category][$id] ?? $this->placeholder_image;
    }

    protected function getNotNulls(array $columns): array
    {
        return array_values(array_filter($columns, static function ($item) {
            return !is_null($item) && $item !== '' && $item !== '0.00';
        }));
    }

    protected function stringIsCategory(?string $str): bool
    {
        $str = $str ?? '';
        return (trim($str)[0] ?? '') === '~';
    }

    protected function stringIsSubCategory(?string $str): bool
    {
        $str = $str ?? '';
        return (trim($str)[0] ?? '') === '*';
    }

    protected function removeMultipleSpaces(?string $string): string
    {
        return preg_replace('/\s\s+/', ' ', $string ?? '');
    }

    /**
     * @param string $article
     * @param array[] $items
     * @param string[] $column_names
     * @param int $i Iteration index
     *
     * @return string[]
     */
    protected function getColumns(string $article, array $items, array $column_names, int $i): array
    {
        $article = $article instanceof RichText ? $article->getPlainText() : $article;
        $columns = ['article' => trim($article)];

        $index = 1;

        foreach ($column_names as $name) {
            $value = $items[$index][$i];
            $columns[$name] = is_string($value) ? trim($value) : $value;
            $index++;
        }

        return $columns;
    }
}