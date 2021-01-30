<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PriceList;
use Illuminate\Contracts\View\View;
use Serhii\Ago\TimeAgo;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function index(): View
    {
        return view('dashboard', [
            'price' => $price = PriceList::getLatest(1),
            'last_upload' => $price ? TimeAgo::trans($price->created_at->toDateTimeString()) : '-',
            'last_request' => TimeAgo::trans(cache()->get('last_request')),
        ]);
    }
}
