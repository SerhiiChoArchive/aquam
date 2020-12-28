<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function index(): View
    {
        return view('images');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['images' => ['required']]);

        if (!$request->file('images')) {
            return back()->with('error', 'Файл не найден');
        }

        $file_category = $request->get('file-category');

        $request->file('images')->storeAs('csv', "$file_category.csv");

        return back()->with('success', 'Файл сохранен');
    }
}
