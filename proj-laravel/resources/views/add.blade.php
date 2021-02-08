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
    <form method="POST" action="/">
        {{csrf_field()}}
        <label for="login">Логин: </label>
        <input name="login" id="login" type="text" placeholder="Логин">
        <label for="password">Пароль: </label>
        <input name="password" id="password" type="text" placeholder="Пароль">
        <label for="name">Имя: </label>
        <input name="name" id="name" type="text" placeholder="Имя">
        <label for="email">Емейл: </label>
        <input name="email" id="email" type="text" placeholder="Электронная почта">
        <input type="submit" name="add" value="Добавить"/>
    </form>
    <a href="/">Назад</a>
    <div>
        {{$message}}
    </div>
</body>
</html>


