<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Converter;
use App\CsvHandler;
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
        $file_data = new CsvHandler($converter->getCsvFilePath());
        $file_data->saveData();

        return back()->with('success', 'Файл загружен и данный успешно обновленны!');
    }

    public function validateRequest(Request $request): ?string
    {
        if (!$request->has('file')) {
            return 'Выберите xls файл';
        }

        if ($request->password !== config('app.password')) {
            return 'Неправильный пароль';
        }

        return null;
    }
}
