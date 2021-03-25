<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PriceList;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImagesController extends Controller
{
    public function store(Request $request): string
    {
        $file = $request->file('file');
        $article = $request->get('article');

        $image_url = $this->saveFile($article, $file);

        $this->updatePriceListInDatabase($image_url, $request->get('category'), $article);

        return $image_url;
    }

    private function saveFile(string $article, UploadedFile $file): string
    {
        $file_name = sprintf("%s-%s.%s", Str::slug($article), time(), $file->getClientOriginalExtension());
        $file->move(storage_path('app/public/uploads'), $file_name);

        return asset("storage/uploads/$file_name");
    }

    private function updatePriceListInDatabase(string $image_url, string $category, string $article): void
    {
        $price_list = PriceList::getLatest(2);

        if (!$price_list) {
            return;
        }

        $category === 'fish'
            ? $this->updateFish($article, $image_url, $price_list)
            : $this->updateOthers($article, $image_url, $price_list, $category);
    }

    private function updateFish(string $article, string $image_url, PriceList $price_list): void
    {
        $fish = array_map(static function ($items) use ($article, $image_url) {
            foreach ($items as &$item) {
                if ($item['article'] === $article) {
                    $item['image'] = $image_url;
                    break;
                }
            }

            return $items;
        }, $price_list->fish);

        $price_list->update(['fish' => $fish]);
    }

    private function updateOthers(string $article, string $image_url, PriceList $price_list, string $category): void
    {
        $result = array_map(static function ($items) use ($article, $image_url) {
            foreach ($items as &$inner_items) {
                if (isset($inner_items['article'])) {
                    if ($inner_items['article'] === $article) {
                        $inner_items['image'] = $image_url;
                        break;
                    }
                } else {
                    foreach ($inner_items as &$item) {
                        if ($item['article'] === $article) {
                            $item['image'] = $image_url;
                            break 2;
                        }
                    }
                }
            }

            return $items;
        }, $price_list->{$category});

        $price_list->update([$category => $result]);
    }
}
