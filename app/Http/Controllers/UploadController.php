<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Converter;
use App\CsvHandler;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request): RedirectResponse
    {
        $validate = $this->validateRequest($request);

        if (!is_null($validate)) {
            return back()->with('error', $validate);
        }

        $converter = new Converter($request->file->getPathName());
        $file_path = $converter->getCsvFilePath();

        if (empty($file_path)) {
            return back()->with('error', 'Ошибка конвертации файла');
        }

        (new CsvHandler($file_path))->saveData();

        try {
            cache()->put('last_upload', date('Y-m-d H:i:s'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());
        }

        return back()->with('success', 'Файл загружен и данный успешно обновленны!');
    }

    public function uploadImages(Request $request): RedirectResponse
    {
        $request->file('images')->storeAs('csv', 'images.csv');

        return back()->with('success', 'Файл сохранен');
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
