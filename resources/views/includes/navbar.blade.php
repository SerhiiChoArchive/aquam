<nav class="teal darken-2">
    <div class="container nav-wrapper">
        <a href="/" class="brand-logo" style="font-size: 24px">Aqua-m</a>
        <a href="#" data-target="mobile-demo1" class="sidenav-trigger">
            <img src="{{ asset('storage/menu.png') }}" width="27" style="margin-top:14px">
        </a>

        <ul class="sidenav" id="mobile-demo1">
            @include('includes.menu')
        </ul>

        <ul id="nav-mobile" class="right hide-on-med-and-down">
            @include('includes.menu')
        </ul>
    </div>
</nav>

<form action="{{ route('logout') }}" id="logout-form" method="post">@csrf</form>
