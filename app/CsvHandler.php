<?php declare(strict_types=1);

namespace App;

use SplFileObject;

final class CsvHandler
{
    /** @var string $file_path */
    private $file_path;

    /** @var string $title */
    private $title = '';

    /** @var string $placeholder_image */
    private $placeholder_image = 'https://i.ibb.co/9tpYXHz/fish-placeholder.jpg';

    /** @var array $titles */
    private $titles = [];

    /** @var null|array $images */
    private $images = null;

    public function __construct(string $file_path)
    {
        $this->file_path = $file_path;
        $this->images = $this->getImagesFromCSV();
    }

    public function saveData(): void
    {
        $file = new SplFileObject($this->file_path);

        $result = [];

        while (!$file->eof()) {
            $result[] = $file->fgetcsv();
        }

        $result = $this->addTitlesForArrayItems($result);

        cache()->forever('price-list', json_encode($result, JSON_UNESCAPED_UNICODE));
        unlink($this->file_path);
    }

    private function titleIsNotValid(): bool
    {
        return empty($this->title) || mb_strlen($this->title) > 40;
    }

    private function addTitlesForArrayItems(array $items): array
    {
        $new_items = [];

        foreach (array_slice($items, 4) as $item) {
            $first_item = $item[0] ?? null;

            if ($this->itemIsNotNumeric($first_item)) {
                $title = $this->trimTitle($first_item);
                $this->title = $title;
                $this->titles[] = $this->trimTitle($first_item);
            }

            if ($this->titleIsNotValid()) {
                continue;
            }

            $image = $this->images[$item[1]] ?? $this->placeholder_image;

            $new_items[$this->title][] = [
                'number' => (int) $item[0],
                'name' => trim($item[1]),
                'size' => $item[2],
                'price' => $item[3],
                'comment' => $item[4],
                'order' => $item[5],
                'sum' => $item[6],
                'image' => $image,
            ];
        }

        $new_items = $this->removeFirstItemFromEachArrayItem($new_items);

        return $this->removeEmptyItems($new_items);
    }

    private function removeEmptyItems(array $arr): array
    {
        return array_filter($arr, function ($item) {
            return !empty($item);
        });
    }

    private function removeFirstItemFromEachArrayItem(array $array): array
    {
        return array_map(function ($item) {
            return array_slice($item, 1);
        }, $array);
    }

    private function itemIsNotNumeric(?string $item): bool
    {
        return !is_numeric($item) && !is_null($item);
    }

    private function trimTitle(?string $title): string
    {
        return trim($title ?? '', "\t\n\r\0\x0B ф");
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

            $result[current($csv)] = last($csv);
        }

        return $result;
    }
}
