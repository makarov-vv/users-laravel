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
<form method="POST" action="/{{$user->Id}}/edit">
    {{csrf_field()}}
    <input type="hidden" name="id" value="{{$user->Id}}">
    <label for="login">Логин: </label>
    <input name="login" id="login" type="text" placeholder="Логин" value="{{$user->Login}}">
    <label for="password">Пароль: </label>
    <input name="password" id="password" type="text" placeholder="Пароль" value="{{$user->Password}}">
    <label for="name">Имя: </label>
    <input name="name" id="name" type="text" placeholder="Имя" value="{{$user->Name}}">
    <label for="email">Емейл: </label>
    <input name="email" id="email" type="text" placeholder="Электронная почта" value="{{$user->Email}}">
    <input type="submit" name="add" value="Изменить"/>
</form>
<div>
    {{$message}}
</div>
</body>
</html>


