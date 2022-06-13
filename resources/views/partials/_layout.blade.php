<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KENSHU TIMES</title>

    <link rel="stylesheet" href="css/app.css">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    @include('partials._header')

    <main>
        @yield('content')
    </main>
    <script src="/js/app.js"></script>
</body>

</html>
