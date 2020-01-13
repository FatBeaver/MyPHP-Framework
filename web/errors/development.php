<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ошибка</title>
</head>
<body>
    <div>
        <h1>Произошла ошибка:</h1>
        <p><b>Код ошибки : </b><?= $errno ?></p>
        <p><b>Текст ошибки : </b><?= $errstr ?></p>
        <p><b>Файл в котором произошла ошибка : </b><?= $errfile ?></p>
        <p><b>Строка с ошибкой : </b><?= $errline ?></p>
    </div>
</body>
</html>