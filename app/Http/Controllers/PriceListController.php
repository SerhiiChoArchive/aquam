<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\ConversionResult;
use App\Converters\V1\XlsxToArray as V1XlsxToArray;
use App\Converters\V2\XlsxToArray as V2XlsxToArray;
use App\Exceptions\PriceListValidationException;
use App\Helper;
use App\Models\PriceList;
use Error;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
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
        $latest = PriceList::getLatest(1);
        $pre_latest = PriceList::getPreLatest(1);

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
        $new_file_name = sprintf("%s-%s.xlsx", date('Y-m-d_H-i-s'), time());
        $file = $request->file('file');

        if (!$file) {
            return back()->with('error', 'Файл не найден');
        }

        $pathname = $file->move(storage_path('app/xlsx'), $new_file_name)->getPathname();

        $converter_v1 = new V1XlsxToArray($pathname, new Xlsx());
        $converter_v2 = new V2XlsxToArray($pathname, new Xlsx());

        try {
            $result_v1 = $converter_v1->convert();
            $result_v2 = $converter_v2->convert();
        } catch (PriceListValidationException $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', $e->getMessage());
        } catch (Exception | SpreadsheetException | TypeError | Error $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Произошла ошибка');
        }

        $this->savePriceListWithVersion(1, $result_v1, $request->user()->id);
        $this->savePriceListWithVersion(2, $result_v2, $request->user()->id);

        Cache::forever('last_upload', date('Y-m-d H:i:s'));
        File::delete($pathname);

        return back()->with('success', 'Файл загружен и данный успешно обновленны!');
    }

    private function savePriceListWithVersion(int $api_version, ConversionResult $result, int $user_id): void
    {
        PriceList::query()->create([
            'user_id' => $user_id,
            'fish' => $result->getFish(),
            'equipment' => $result->getEquipment(),
            'feed' => $result->getFeed(),
            'chemistry' => $result->getChemistry(),
            'aquariums' => $result->getAquariums(),
            'api_version' => $api_version,
        ]);
    }
}
