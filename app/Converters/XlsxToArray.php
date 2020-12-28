<?php

declare(strict_types=1);

namespace App\Converters;

use App\ConversionResult;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use SplFileObject;

class XlsxToArray
{
    use CanConvertToFish;

    private const NUMBER_OF_SHEETS_WE_NEED = 5;

    private string $pathname;
    private Xlsx $xlsx_reader;
    private ?array $images;
    private string $placeholder_image = 'https://i.ibb.co/9tpYXHz/fish-placeholder.jpg';

    public function __construct(string $pathname, Xlsx $xlsx_reader)
    {
        $this->pathname = $pathname;
        $this->xlsx_reader = $xlsx_reader;
        $this->images = $this->getImagesFromCSV();
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
            $this->convertTo($sheets['equipment'], ['name', 'description', 'producer', 'price']),
            $this->convertTo($sheets['feed'], ['name', 'description', 'weight', 'price']),
            $this->convertTo($sheets['chemistry'], ['name', 'capacity', 'description', 'price']),
            $this->convertTo($sheets['aquariums'], ['name', 'capacity', 'description', 'price']),
        );
    }

    private function getImagesFromCSV(): ?array
    {
        $file_path = storage_path('app/csv/images.csv');

        if ( ! file_exists($file_path)) {
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
        return $this->images[$id] ?? $this->placeholder_image;
    }

    private function getNotNulls(array $columns): array
    {
        return array_filter($columns, function ($item) {
            return !is_null($item) && $item !== '' && $item !== '0.00';
        });
    }

    /**
     * @param array[] $items
     * @param array $column_names
     *
     * @return array[]
     * @throws \Exception
     */
    private function convertTo(array $items, array $column_names): array
    {
        $result = [];
        $title = '';

        for ($i = 1; $i < count($items[0]); $i++) {
            $article = $items[0][$i] ?? '';

            if ($article instanceof RichText) {
                $article = $article->getPlainText();
            }

            $columns = ['article' => is_int($article) ? (string) $article : trim($article)];
            $index = 1;

            foreach ($column_names as $name) {
                $value = $items[$index][$i];
                $columns[$name] = is_string($value) ? trim($value) : $value;
                $index++;
            }

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
}