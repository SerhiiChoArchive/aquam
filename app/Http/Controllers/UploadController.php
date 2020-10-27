<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\ConversionResult;
use App\XlsToArrayConverter;
use Error;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use TypeError;

class UploadController extends Controller
{
    public function upload(Request $request): RedirectResponse
    {
        $validate = $this->validateRequest($request, 'file');

        if ($validate) {
            return back()->with('error', $validate);
        }

        $new_file_name = sprintf("%s-%s.xls", date('Y-m-d_H-i-s'), time());
        $pathname = $request->file('file')->move(storage_path('app/xls'), $new_file_name)->getPathname();

        $converter = new XlsToArrayConverter($pathname, new Xls());

        try {
            $result = $converter->convert();
        } catch (Exception | TypeError | Error $e) {
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Ошибка при попытке конвертации данных');
        }

        $this->cacheTheData($result);

        return back()->with('success', 'Файл загружен и данный успешно обновленны!');
    }

    public function uploadImages(Request $request): RedirectResponse
    {
        $validate = $this->validateRequest($request, 'images');

        if (!is_null($validate)) {
            return back()->with('error', $validate);
        }

        $request->file('images')->storeAs('csv', 'images.csv');

        return back()->with('success', 'Файл сохранен');
    }

    public function validateRequest(Request $request, string $param_name): ?string
    {
        if (!$request->has($param_name) || is_null(request($param_name))) {
            return 'Выберите файл';
        }

        return null;
    }

    /**
     * @param \App\ConversionResult $result
     */
    private function cacheTheData(ConversionResult $result): void
    {
        Cache::forever(ConversionResult::FISH, $this->encodeData($result->getFish()));
        Cache::forever(ConversionResult::EQUIPMENT, $this->encodeData($result->getEquipment()));
        Cache::forever(ConversionResult::FEED, $this->encodeData($result->getFeed()));
        Cache::forever(ConversionResult::CHEMISTRY, $this->encodeData($result->getChemistry()));

        Cache::forever('last_upload', date('Y-m-d H:i:s'));
    }

    /**
     * @param array[] $result
     *
     * @return false|string
     */
    private function encodeData(array $result)
    {
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
