<?php

declare(strict_types=1);

namespace App\Converters\V1;

use App\Converters\XlsToArray;

class XlsxToArray extends XlsToArray
{
    /**
     * @param array[] $items
     * @param string[] $column_names
     * @param string $images_category
     *
     * @return array[]
     * @throws \App\Exceptions\PriceListValidationException
     */
    protected function convertTo(array $items, array $column_names, string $images_category): array
    {
        $result = [];
        $title = '';

        for ($i = 1, $i_max = count($items[0]); $i < $i_max; $i++) {
            $article = $items[0][$i] ?? '';
            $next_article = (string) ($items[0][$i + 1] ?? '');

            $columns = $this->getColumns($article, $items, $column_names, $i);
            $not_nulls = $this->getNotNulls($columns);

            if (empty($not_nulls)) {
                continue;
            }

            if (count($not_nulls) === 1) {
                if (is_object(current($not_nulls))) {
                    continue;
                }

                $title = current($not_nulls);
                $this->throwIfTitleDoesntHaveSpecialCharacters($title, $next_article);
                continue;
            }

            $image = $this->getImageFrom($columns['article'], $images_category);
            $title = $this->removeMultipleSpaces(trim($title, '*~ '));

            $result[$title][] = array_merge($columns, compact('image'));
        }

        return $result;
    }
}