<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\PriceList;
use Illuminate\Support\Facades\Cache;

class JsonController extends Controller
{
    public function fish(): array
    {
        return PriceList::getLatestCategory('fish', 1);
    }

    public function equipment(): array
    {
        return PriceList::getLatestCategory('equipment', 1);
    }

    public function feed(): array
    {
        return PriceList::getLatestCategory('feed', 1);
    }

    public function chemistry(): array
    {
        return PriceList::getLatestCategory('chemistry', 1);
    }

    public function aquariums(): array
    {
        return PriceList::getLatestCategory('aquariums', 1);
    }

    public function info(): string
    {
        Cache::put('last_request', date('Y-m-d H:i:s'));
        return PriceList::query()->select('created_at')->latest()->first()->created_at->format('d.m.Y');
    }
}
