<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <title>@yield('title') | Aqua-m</title>
</head>
<body>

    <nav class="teal darken-2">
        <div class="container nav-wrapper">
            <a href="/" class="brand-logo" style="font-size: 24px">Aqua-m</a>
            <a href="#" data-target="mobile-demo1" class="sidenav-trigger"><img src="images/menu.png" width="27" style="margin-top:15px"></a>

            <ul class="sidenav" id="mobile-demo1">
                @include('includes.menu')
            </ul>

            <ul id="nav-mobile" class="right hide-on-med-and-down">
                @include('includes.menu')
            </ul>
        </div>
    </nav>

    @yield('content')

    <form action="{{ route('logout') }}" id="logout-form" method="post">@csrf</form>

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
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
