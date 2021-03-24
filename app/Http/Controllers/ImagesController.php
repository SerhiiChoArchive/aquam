<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImagesController extends Controller
{
    public function store(Request $request): int
    {
        $file = $request->file('file');
        $article = $request->get('article');
        $file_name = Str::slug($article) . '.' . $file->getClientOriginalExtension();

        $file->move(storage_path('app/public/uploads'), $file_name);

        return 1;
    }
}
