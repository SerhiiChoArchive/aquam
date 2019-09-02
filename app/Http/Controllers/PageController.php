<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'last_upload' => time_ago(cache()->get('last_upload')),
        ]);
    }
}
