<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('app/css/app.css') }}?v1">

        <title>DevSquad</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    </head>
    <body>
        <noscript>
            <strong>We're sorry but teste doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
        </noscript>
        <main id="app"></main>
        <script type="text/javascript" charset="UTF-8" src="{{ asset('app/js/app.js') }}?v1"></script>
    </body>
</html>
