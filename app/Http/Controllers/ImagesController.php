<?php

declare(strict_types=1);

namespace App\Http\Controllers;

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

        return $image_url;
    }

    private function saveFile(string $article, UploadedFile $file): string
    {
        $file_name = Str::slug($article) . '.' . $file->getClientOriginalExtension();
        $file->move(storage_path('app/public/uploads'), $file_name);

        return asset("storage/uploads/$file_name");
    }
}
