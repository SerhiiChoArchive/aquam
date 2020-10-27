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

        $request->file('images')->storeAs('csv', 'images.csv');

        return back()->with('success', 'Файл сохранен');
    }
}
