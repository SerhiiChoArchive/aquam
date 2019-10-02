<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <title>@yield('title') | Aqua-m</title>
</head>
<body>
    <nav class="teal darken-2">
        <div class="container nav-wrapper">
            <a href="/" class="brand-logo" style="font-size: 22px;">Панель управления</a>

            <ul id="nav-mobile" class="right hide-on-med-and-down">
                @auth
                    <li class="{{ active_if_route_is(['/']) }}"><a href="/">Панель</a></li>
                    <li class="{{ active_if_route_is(['update-data']) }}"><a href="/update-data">Обновить данные</a></li>
                    <li class=""><a href="javascript:" onclick="document.getElementById('logout-form').submit()">Выйти</a></li>
                @endauth
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

        document.addEventListener('DOMContentLoaded', function() {
            var inst = M.Collapsible.init(document.querySelectorAll('.collapsible'));
        });

        var images = document.querySelectorAll('.materialboxed')

        if (images) {
            document.addEventListener('DOMContentLoaded', function() {
                M.Materialbox.init(images);
            });
        }
    </script>
</body>
</html>
