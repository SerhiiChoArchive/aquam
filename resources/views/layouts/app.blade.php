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
    <nav>
        <div class="nav-wrapper teal darken-1">
            <a href="/" class="brand-logo" style="padding-left:10px;font-size: 22px;">Панель управления</a>

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
    </script>
</body>
</html>
