<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        @vite(['resources/js/common.js', 'resources/js/app.js', 'resources/css/app.scss'])
    </head>
    <body>
        <div id="app">
            @include('components.header')
            <main class="main">
            	<div class="wrapper">
                	<h1>{{ $name }}</h1>
                </div>
            </main>
            @include('components.footer')
        </div>
    </body>
</html>
