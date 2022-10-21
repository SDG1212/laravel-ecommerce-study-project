<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        @include('components.header')
        <main id="catalog" class="main"></main>
        @include('components.footer')
        <div id="alert-box"></div>
    </body>
</html>
