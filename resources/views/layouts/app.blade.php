<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('storage/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>@yield('title') | Aqua-m</title>
</head>
<body>
    @include('includes.navbar')
    @yield('content')

    @include('includes.messages')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
