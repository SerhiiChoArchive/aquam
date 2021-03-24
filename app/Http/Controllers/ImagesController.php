<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        return back()->with('success', 'Файл сохранен');
    }
}
