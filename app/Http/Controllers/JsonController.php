<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class JsonController extends Controller
{
    public function priceList(): Response
    {
        return response(Cache::get('price-list'), 200, ['Content-Type' => 'application/json']);
    }

    public function info()
    {
        Cache::put('last_request', date('Y-m-d H:i:s'));

        return response(date('d.m.Y', strtotime(Cache::get('last_upload'))), 200);
    }
}
