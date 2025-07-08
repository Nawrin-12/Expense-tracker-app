@extends('layouts.app')
@section('content')

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
</head>
<body>
<h2>Login</h2>
{{--<form method="POST" action="/expenses">--}}
<form action="{{ route('login') }}" method="POST">
    @csrf
    <input type="email" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <button type="submit">Login</button>
</form>

</body>
</html>

@endsection

