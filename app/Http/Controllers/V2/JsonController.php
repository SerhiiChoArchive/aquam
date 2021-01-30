<?php

declare(strict_types=1);

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\PriceList;

class JsonController extends Controller
{
    public function fish(): array
    {
        return PriceList::getLatestCategory('fish', 2);
    }

    public function equipment(): array
    {
        return PriceList::getLatestCategory('equipment', 2);
    }

    public function feed(): array
    {
        return PriceList::getLatestCategory('feed', 2);
    }

    public function chemistry(): array
    {
        return PriceList::getLatestCategory('chemistry', 2);
    }

    public function aquariums(): array
    {
        return PriceList::getLatestCategory('aquariums', 2);
    }
}
