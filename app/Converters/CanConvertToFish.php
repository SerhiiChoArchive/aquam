<?php

declare(strict_types=1);

namespace App\Converters;

use Exception;

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

        for ($i = 3; $i < count($price_list[0]); $i++) {
            $name = $price_list[1][$i];

            $columns = [
                'number' => $price_list[0][$i],
                'name' => $name,
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

            if (is_null($name)) {
                throw new Exception('Проверьте колонку "Наименование" в "Акв.рыба", одина из них пустая.');
            }

            $image = $this->getImageFrom($name);

            $result[$title][] = array_merge($columns, compact('image'));
        }

        return $result;
    }
}