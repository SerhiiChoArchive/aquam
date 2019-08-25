<?php
require_once 'vendor/autoload.php';
use App\Helper;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/main.css">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/x-icon">
    <title>Загрузить файл</title>
</head>
<body>
    <div class="container">
        <p><img src="assets/logo-aqua.png" alt="logo"></p>

        <form action="inc/upload" method="POST" enctype="multipart/form-data">
            <div class="input-field">
                <label class="input-upload-label" for="input-file" data-title="✚ Выбрать CSV файл">
                    <input type="file" name="file" id="input-file" required>
                </label>

                <small class="input-upload-file-path">
                    <b id="file-path"></b>
                </small>
            </div>
            <div class="input-field">
                <input type="password" name="password" id="password" placeholder="Пароль" required>
            </div>
            <button type="submit">Загрузить</button>
        </form>

        <?php if (isset($_GET['msg'])): ?>
        <div>
            <div class="message">
                <p><?= Helper::getValidationMessage(); ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <script src="assets/main.js"></script>
</body>
</html>