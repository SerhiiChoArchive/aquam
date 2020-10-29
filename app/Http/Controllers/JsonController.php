<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PriceList;
use Illuminate\Support\Facades\Cache;

class JsonController extends Controller
{
    public function fish(): array
    {
        return PriceList::getLatestCategory('fish');
    }

    public function equipment(): array
    {
        return PriceList::getLatestCategory('equipment');
    }

    public function feed(): array
    {
        return PriceList::getLatestCategory('feed');
    }

    public function chemistry(): array
    {
        return PriceList::getLatestCategory('chemistry');
    }

    public function aquariums(): array
    {
        return PriceList::getLatestCategory('aquariums');
    }

    public function info(): string
    {
        Cache::put('last_request', date('Y-m-d H:i:s'));
        return PriceList::query()->select('created_at')->latest()->first()->created_at->format('d.m.Y');
    }
}
