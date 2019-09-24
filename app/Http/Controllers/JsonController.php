<?php

namespace App\Http\Controllers;

use App\TimeAgo;
use Illuminate\Http\Response;

class JsonController extends Controller
{
    public function priceList(): Response
    {
        $this->handleHash();

        return response(cache('price-list'), 200, [
            'Content-Type' => 'application/json',
        ]);
    }

    private function handleHash(): void
    {
        cache()->increment('all_requests');

        $visits = cache()->get('requests_today') ?? 0;
        cache()->put('requests_today', ++$visits, 60 * 60 * 24);

        cache()->put('last_request', date('Y-m-d H:i:s'));
    }
}
