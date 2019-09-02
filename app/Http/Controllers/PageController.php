<?php

namespace App\Http\Controllers;

use App\TimeAgo;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'last_upload' => TimeAgo::get(cache()->get('last_upload')),
        ]);
    }
}
