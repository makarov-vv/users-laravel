<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Главная</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<form enctype="multipart/form-data" method="POST" action="/import">
    {{csrf_field()}}
    <div>
        <label for="file">Файл: </label>
        <input name="file" id="file" type="file" placeholder="Выберите файл" accept=".xml, .csv">
    </div>
    <input type="submit" name="import" value="Импортировать"/>
</form>
</body>
</html>


