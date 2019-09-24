<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <title>@yield('title') | Aqua-m</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</head>
<body>
    @yield('content')

    {{-- Alert messages --}}
    <script>
        @if (session('error'))
            M.toast({
                html: "{{ session('error') }}",
                classes: "red darken-2",
            })
        @elseif (session('success'))
            M.toast({
                html: "{{ session('success') }}",
                classes: "green darken-2",
            })
        @endif
    </script>
</body>
</html>
