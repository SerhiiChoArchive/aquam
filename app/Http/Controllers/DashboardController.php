<?php

declare(strict_types=1);

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
        return view('dashboard', [
            'last_upload' => Time::ago(cache()->get('last_upload')),
            'last_request' => Time::ago(cache()->get('last_request')),
            'price_list' => $price_list = auth()->user()->priceLists->last(),
        ]);
    }
}
