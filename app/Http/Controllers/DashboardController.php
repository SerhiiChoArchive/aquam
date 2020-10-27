<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper;
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
        return view('dashboard', [
            'price_list' => $price_list = auth()->user()->priceLists->last(),
            'last_upload' => Time::ago($price_list->created_at),
            'last_request' => Time::ago(cache()->get('last_request')),
            'count_fish' => Helper::countArrayItems($price_list->fish),
            'count_equipment' => Helper::countArrayItems($price_list->equipment),
            'count_feed' => Helper::countArrayItems($price_list->feed),
            'count_chemistry' => Helper::countArrayItems($price_list->chemistry),
            'count_aquariums' => Helper::countArrayItems($price_list->aquariums),
        ]);
    }
}
