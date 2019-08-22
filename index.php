<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузить файл</title>
</head>
<body>
    <div class="container">
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <label for="file">Выбрать CSV файл</label>
            <input type="file" name="file" id="file">
            <button type="submit">Загрузить</button>
        </form>
    </div>
    <style>
        body {
            margin: 0;
            font-family: Helvetica, Arial, sans-serif;
        }

        .container {
            max-width: 1000px;
            text-align: left;
            padding: 40px 10%;
        }

        form label {
            display: block;
            margin: 12px 0;
            font-size: 14px;
            font-weight: bold;
        }

        form input {
            display: block;
            margin-bottom: 15px;
        }

        button {
            background: #447e80;
            color: white;
            border: none;
            border-radius: 3px;
            padding: 8px 32px;
            font-size: 19px;
            box-shadow: 2px 2px 4px #bbbaba;
        }
    </style>
</body>
</html>