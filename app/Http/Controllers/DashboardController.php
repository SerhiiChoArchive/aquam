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
            'price' => $price = auth()->user()->priceLists->last(),
            'last_upload' => $price ? Time::ago($price->created_at->toDateTimeString()) : '-',
            'last_request' => Time::ago(cache()->get('last_request')),
            'count_fish' => $price ? Helper::countArrayItems($price->fish) : 0,
            'count_equipment' => $price ? Helper::countArrayItems($price->equipment) : 0,
            'count_feed' => $price ? Helper::countArrayItems($price->feed) : 0,
            'count_chemistry' => $price ? Helper::countArrayItems($price->chemistry) : 0,
            'count_aquariums' => $price ? Helper::countArrayItems($price->aquariums) : 0,
        ]);
    }
}
