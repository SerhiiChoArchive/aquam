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
        <div class="nav-wrapper teal">
            <a href="#" class="brand-logo" style="padding-left:10px">Aqua-m</a>

            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="badges.html">Components</a></li>
                <li><a href="collapsible.html">JavaScript</a></li>
            </ul>
        </div>
    </nav>

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

        document.addEventListener('DOMContentLoaded', function() {
            var inst = M.Collapsible.init(document.querySelectorAll('.collapsible'));
        });
    </script>
</body>
</html>
