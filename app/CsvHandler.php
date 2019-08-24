<?php declare(strict_types=1);

namespace App;

use SplFileObject;

final class CsvHandler
{
    /** @var string $file_path */
    private $file_path;

    /** @var string $title */
    private $title = '';

    /** @var array $titles */
    private $titles = [];

    public function __construct(string $file_path)
    {
        $this->file_path = $file_path;
    }

    public function saveData(): void
    {
        $file = new SplFileObject($this->file_path);

        $result = [];

        while (!$file->eof()) {
            $result[] = $file->fgetcsv();
        }

        file_put_contents(__DIR__ . '/../cache/fish', json_encode([
            'status' => 200,
            'data' => $this->addTitlesForArrayItems($result),
        ], JSON_UNESCAPED_UNICODE));
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

            $new_items[$this->title][] = array_slice($item, 0, 7);
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

    private function trimTitle(string $title): string
    {
        return trim($title, "\t\n\r\0\x0B ф");
    }
}
