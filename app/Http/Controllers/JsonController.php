<?php

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
}
