<?php

declare(strict_types=1);

namespace App\Converters\V2;

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
        $category = '';
        $sub_category = '';

        for ($i = 1, $i_max = count($items[0]); $i < $i_max; $i++) {
            $article = $items[0][$i] ?? '';
            $next_article = (string) ($items[0][$i + 1] ?? '');

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
            }

            $image = $this->getImageFrom($columns['article'], $images_category);

            $clean_title = trim($title ?? '', '*~ ');
            $clean_next_title = trim($next_article, '*~ ');

            if ($sub_category === '' && $this->stringIsSubCategory($next_article)) {
                $sub_category = $clean_next_title;
            }

            if ($this->stringIsCategory($title)) {
                $category = $clean_title;
                $sub_category = '';
            }

            if ($this->stringIsSubCategory($title)) {
                $sub_category = $clean_title;
            }

            if (count($not_nulls) === 1) {
                continue;
            }

            [$category, $sub_category] = $this->removeMultipleSpaces($category, $sub_category);

            $sub_category === ''
                ? $result[$category][] = array_merge($columns, compact('image'))
                : $result[$category][$sub_category][] = array_merge($columns, compact('image'));
        }

        return $result;
    }

    /**
     * @param string|null $category
     * @param string|null $sub_category
     *
     * @return array
     */
    protected function removeMultipleSpaces(?string $category, ?string $sub_category): array
    {
        $category = preg_replace("/\s\s+/", ' ', $category ?? '');
        $sub_category = preg_replace("/\s\s+/", ' ', $sub_category ?? '');

        return [$category, $sub_category];
    }
}