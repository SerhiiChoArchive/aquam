<?php

namespace App\Http\Controllers;

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

    public function info()
    {
        return response(date('d-m-Y', strtotime(cache()->get('last_upload'))), 200);
    }

    private function handleHash(): void
    {
        $requests = (int) cache()->get('all_requests');
        cache()->forever('all_requests', ++$requests);

        $visits = cache()->get('requests_today') ?? 0;
        cache()->put('requests_today', ++$visits, 60 * 60 * 24);

        cache()->put('last_request', date('Y-m-d H:i:s'));
    }
}
