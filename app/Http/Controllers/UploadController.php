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
        $validate = $this->validateRequest($request, 'file');

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

        if ($request->password !== config('app.password')) {
            return 'Неправильный пароль';
        }

        return null;
    }
}
