@extends('layouts.app')

@section('content')
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
</head>
<body>
<h2>Fill up the form to Register your account</h2>
<form method="POST" action="/api/register">
    <input type="text" name="name" placeholder="Name"><br>
    <input type="email" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <input type="password" name="password_confirmation" placeholder="Confirm Password"><br>
    <input type="number" name="number" placeholder="Contact Number"><br>
    <button type="submit">Submit</button>
</form>


{{--<p>Already have an account? <a href="/login">Login</a></p>--}}
{{--<p><a href="/forgot-password">Forgot your password?</a></p>--}}
</body>
</html>

@endsection
