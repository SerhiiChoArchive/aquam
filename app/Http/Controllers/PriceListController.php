<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PriceList;
use App\Converters\XlsToArray;
use Error;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use TypeError;

class PriceListController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function index(): View
    {
        $diff_items = cache()->get('diff-items') ?? '[]';
        return view('price-list', ['diff_items' => json_decode($diff_items)]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['file' => ['required']]);

        $new_file_name = sprintf("%s-%s.xls", date('Y-m-d_H-i-s'), time());
        $pathname = $request->file('file')->move(storage_path('app/xls'), $new_file_name)->getPathname();

        $converter = new XlsToArray($pathname, new Xls());

        try {
            $result = $converter->convert();
        } catch (Exception | TypeError | Error $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', <<<TEXT
            Ошибка при попытке конвертации данных.
            Проверьте правильность введенных данных в прайс.
            TEXT);
        }

        PriceList::query()->create([
            'user_id' => $request->user()->id,
            'fish' => $result->getFish(),
            'equipment' => $result->getEquipment(),
            'feed' => $result->getFeed(),
            'chemistry' => $result->getChemistry(),
            'aquariums' => $result->getAquariums(),
        ]);

        Cache::forever('last_upload', date('Y-m-d H:i:s'));

        return back()->with('success', 'Файл загружен и данный успешно обновленны!');
    }
}
