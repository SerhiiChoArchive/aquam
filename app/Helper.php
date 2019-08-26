<?php declare(strict_types=1);

namespace App;

final class Helper
{
    public static function getFileFromRequest(array $files): ?array
    {
        $file = $files['file'] ?? null;
        return $file && !empty($file['type']) && $file['type'] === 'application/vnd.ms-excel' ? $file : null;
    }

    public static function redirect(string $path): void
    {
        header("Location: {$path}");
        exit;
    }

    public static function passwordIsCorrect(array $request): bool
    {
        $config = require_once '../config.php';
        return isset($request['password']) && $config->password === $request['password'];
    }

    public static function getValidationMessage(): ?string
    {
        if ($_GET['msg'] === 'success') return 'Файл загружен и данный успешно обновленны!';
        if ($_GET['msg'] === 'error') return 'Формат файла должен быть формата xls!';
        if ($_GET['msg'] === 'error_pwd_wrong') return 'Неправильный пароль';

        return null;
    }
}