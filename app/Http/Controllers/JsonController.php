<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class JsonController extends Controller
{
    public function priceList(): Response
    {
        return response(cache('price-list'), 200, [
            'Content-Type' => 'application/json',
        ]);
    }

    public function info()
    {
        cache()->put('last_request', date('Y-m-d H:i:s'));
        return response(date('d.m.Y', strtotime(cache()->get('last_upload'))), 200);
    }
}
