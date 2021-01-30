<?php

declare(strict_types=1);

namespace App\Converters\V1;

use App\Converters\XlsToArray;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

class XlsxToArray extends XlsToArray
{
    /**
     * @param array[] $items
     * @param array $column_names
     * @param string $images_category
     *
     * @return array[]
     */
    protected function convertTo(array $items, array $column_names, string $images_category): array
    {
        $result = [];
        $title = '';

        for ($i = 1, $i_max = count($items[0]); $i < $i_max; $i++) {
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

            $image = $this->getImageFrom($columns['article'], $images_category);

            $clean_title = trim($title, '*~ ');
            $result[$clean_title][] = array_merge($columns, compact('image'));
        }

        return $result;
    }
}