<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Converter;
use App\CsvHandler;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SplFileObject;

class UploadController extends Controller
{
    public function upload(Request $request): RedirectResponse
    {
        $images = $this->getImagesFromCSV($request);
        $validate = $this->validateRequest($request);

        if (!is_null($validate)) {
            return back()->with('error', $validate);
        }

        $converter = new Converter($request->file->getPathName());
        $file_path = $converter->getCsvFilePath();

        if (empty($file_path)) {
            return back()->with('error', 'Ошибка конвертации файла');
        }

        (new CsvHandler($file_path, $images))->saveData();

        try {
            cache()->put('last_upload', date('Y-m-d H:i:s'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());
        }

        return back()->with('success', 'Файл загружен и данный успешно обновленны!');
    }

    private function getImagesFromCSV(Request $request): ?array
    {
        if (!$request->has('images') || is_null($request->images)) {
            return null;
        }

        $file = new SplFileObject($request->images->getPathName());

        $result = [];

        while (!$file->eof()) {
            $csv = $file->fgetcsv();

            if (count($csv) !== 2) {
                continue;
            }

            $result[current($csv)] = last($csv);
        }

        return $result;
    }

    public function validateRequest(Request $request): ?string
    {
        if (!$request->has('file') || is_null($request->file)) {
            return 'Выберите xls файл';
        }

        if ($request->password !== config('app.password')) {
            return 'Неправильный пароль';
        }

        return null;
    }
}
