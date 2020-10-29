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
            'price' => $price = auth()->user()->priceLists->last(),
            'last_upload' => $price ? Time::ago($price->created_at->toDateTimeString()) : '-',
            'last_request' => Time::ago(cache()->get('last_request')),
        ]);
    }
}
