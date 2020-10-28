<?php

declare(strict_types=1);

namespace App\Converters;

use Exception;

trait CanConvertToEquipment
{
    /**
     * @param array[] $equip
     *
     * @return array[]
     * @throws \Exception
     */
    private function convertToEquipment(array $equip): array
    {
        $result = [];
        $title = '';

        for ($i = 1; $i < count($equip[0]); $i++) {
            $article = $equip[0][$i] ?? '';

            if (is_object($article) || is_float($article)) {
                throw new Exception(<<<MSG
                Проверьте новые артикли в "Обор-ние, аксессуары", один из них имеет неподдерживаемый тип.
                Убедитесь что артикль является строкой.
                MSG);
            }

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
}