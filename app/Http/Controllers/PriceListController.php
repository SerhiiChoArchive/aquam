<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper;
use App\Models\PriceList;
use App\Converters\XlsxToArray;
use Error;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Exception as SpreadsheetException;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use TypeError;

class PriceListController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function index(): View
    {
        $latest = PriceList::getLatest();
        $pre_latest = PriceList::getPreLatest();

        if (!$latest || !$pre_latest) {
            return view('price-list', ['diff' => new PriceList()]);
        }

        $diff = new PriceList([
            'fish' => Helper::getCategoriesDiff($latest->fish, $pre_latest->fish, 'name'),
            'equipment' => Helper::getCategoriesDiff($latest->equipment, $pre_latest->equipment, 'article'),
            'feed' => Helper::getCategoriesDiff($latest->feed, $pre_latest->feed, 'article'),
            'chemistry' => Helper::getCategoriesDiff($latest->chemistry, $pre_latest->chemistry, 'article'),
            'aquariums' => Helper::getCategoriesDiff($latest->aquariums, $pre_latest->aquariums, 'article'),
        ]);

        return view('price-list', compact('diff'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['file' => ['required']]);

        $new_file_name = sprintf("%s-%s.xlsx", date('Y-m-d_H-i-s'), time());
        $pathname = $request->file('file')->move(storage_path('app/xlsx'), $new_file_name)->getPathname();

        $converter = new XlsxToArray($pathname, new Xlsx());

        try {
            $result = $converter->convert();
        } catch (Exception | SpreadsheetException | TypeError | Error $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', $e->getMessage());
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
