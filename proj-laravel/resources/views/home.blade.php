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
<div>
    <table class="table">
    <tr class="d-flex">
        <th class="col-1">@if ($sort=='asc'&&$field=='login')
                <a href="./?field=login&sort=desc&page=1">Логин</a>
            @else
                <a href="./?field=login&sort=asc&page=1">Логин</a>
        @endif
        </th>
        <th class="col-4">Пароль</th>
        <th class="col-2">
            @if ($sort=='asc'&&$field=='name')
                <a href="./?field=name&sort=desc&page=1">Имя</a>
            @else
                <a href="./?field=name&sort=asc&page=1">Имя</a>
            @endif
        </th>
        <th class="col-3">@if ($sort=='asc'&&$field=='email')
                <a href="./?field=email&sort=desc&page=1">Емейл</a>
            @else
                <a href="./?field=email&sort=asc&page=1">Емейл</a>
            @endif
            </th>
        <th></th>
    </tr>
    @foreach($users as $user)
        <tr class="d-flex"><td class="col-1">{{$user->Login}}</td><td class="col-4">{{$user->Password}}</td><td class="col-2">{{$user->Name}}</td><td class="col-3">{{$user->Email}}</td><td><a href='/{{$user->Id}}/edit'>Изменить</a></td></tr>
    @endforeach
    </table>
    </div>
<div>{{$users->links()}}</div>

<a href="/add">Добавить</a>
<a href="/import">Импорт</a>
<div>
    {{$message}}
</div>
</body>
</html>
