<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class UpdateDataController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function index(): View
    {
        $diff_items = cache()->get('diff-items') ?? '[]';

        return view('update-data', [
            'diff_items' => json_decode($diff_items),
        ]);
    }
}
