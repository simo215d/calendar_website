<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <!--<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        -->
        <!-- Styles -->
        <style>
        
        </style>
    </head>
    <body class="antialiased">
        <div>
        <!--
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            -->
            <p>Calendar!!!!!11</p>
            <a href="/login">Login</a><br>
            <a href="/register">Register</a><br>
            <img src="https://image.freepik.com/free-vector/3d-isometric-flat-concept-calendar_109064-607.jpg" alt="calendar">
        </div>
    </body>
</html>
