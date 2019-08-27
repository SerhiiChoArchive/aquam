<?php declare(strict_types=1);

namespace App;

final class Helper
{
    public static function getValidationMessage(): ?string
    {
        $request = $_GET['msg'] ?? null;

        if ($request === 'success') return 'Файл загружен и данный успешно обновленны!';
        if ($request === 'error') return 'Формат файла должен быть формата xls!';
        if ($request === 'error_pwd_wrong') return 'Неправильный пароль';

        return null;
    }
}
