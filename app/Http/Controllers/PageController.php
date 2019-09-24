<?php

namespace App\Http\Controllers;

use App\TimeAgo;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $price_list = (array) json_decode(cache()->get('price-list') ?? '[]');

        return view('home', [
            'last_upload' => TimeAgo::get(cache()->get('last_upload')),
            'last_request' => TimeAgo::get(cache()->get('last_request')),
            'price_items_amount' => count($price_list, COUNT_RECURSIVE) - count($price_list),
            'price_categories_amount' => count($price_list),
            'price_list' => $price_list,
        ]);
    }
}
