<?php

declare(strict_types=1);

namespace App\Converters;

trait CanConvertToFish
{
    /**
     * @param array $price_list
     *
     * @return array[]
     * @throws \Exception
     */
    private function convertToFish(array $price_list): array
    {
        $result = [];
        $title = '';

        for ($i = 3, $i_max = count($price_list[0]); $i < $i_max; $i++) {
            $name = $price_list[2][$i];
            $article = $price_list[1][$i];

            $columns = [
                'article' => is_string($article) ? trim($article) : $article,
                'name' => is_string($name) ? trim($name) : $name,
                'size' => $price_list[3][$i],
                'price' => $price_list[4][$i],
                'comment' => trim($price_list[5][$i] ?? ''),
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

            $image = $this->getImageFrom($article, 'fish');

            $result[$title][] = array_merge($columns, compact('image'));
        }

        return $result;
    }
}