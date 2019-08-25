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
            <label for="file">Выбрать CSV файл</label>
            <input type="file" name="file" id="file" required>
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