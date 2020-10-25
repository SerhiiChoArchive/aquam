<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Serhii\Ago\Time;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function index(): View
    {
        $price_list = (array) json_decode(cache()->get('price-list') ?? '[]');

        return view('dashboard', [
            'last_upload' => Time::ago(cache()->get('last_upload')),
            'last_request' => Time::ago(cache()->get('last_request')),
            'price_items_amount' => count($price_list, COUNT_RECURSIVE) - count($price_list),
            'price_categories_amount' => count($price_list),
            'price_list' => $price_list,
        ]);
    }
}
