<?php
require_once 'vendor/autoload.php';
use App\Helper;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <style>
        body {
            margin: 0;
            font-family: Helvetica, Arial, sans-serif;
        }

        .container {
            max-width: 1000px;
            text-align: center;
            padding: 10px 10%;
            margin: auto;
        }

        form {
            display: inline-block;
        }

        form label {
            display: block;
            margin: 12px 0;
            font-size: 14px;
            font-weight: bold;
        }

        form input {
            display: block;
            margin: 30px auto;
        }

        button {
            background: #447e80;
            color: white;
            border: none;
            border-radius: 3px;
            padding: 8px 32px;
            font-size: 19px;
            box-shadow: 2px 2px 4px #bbbaba;
            cursor: pointer;
        }

        .message {
            padding: 1px 18px;
            border-left: 5px solid #447e80;
            display: inline-block;
            border-radius: 0px 3px 3px 0;
            margin-top: 30px;
            background-color: #f4fffa;
        }
    </style>
    <script>
        setTimeout(function () {
            document.querySelector('.message').remove()
        }, 3000)
    </script>
</body>
</html>