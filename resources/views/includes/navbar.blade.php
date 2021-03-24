<nav class="teal darken-2">
    <div class="container nav-wrapper">
        <a href="/" class="brand-logo" style="font-size: 24px">Aqua-m</a>

        @auth
            <ul class="right">
                <li>
                    <a class="dropdown-trigger" href="#!" data-target="dropdown1">
                        Меню<i class="material-icons right">menu</i>
                    </a>
                </li>
            </ul>

            <ul id='dropdown1' class='dropdown-content'>
                <li class="{{ App\Helper::activeIfRouteIs(['dashboard']) }}">
                    <a href="{{ action('DashboardController@index') }}" class="black-text">
                        <i class="material-icons">art_track</i>Панель
                    </a>
                </li>
                <li class="{{ App\Helper::activeIfRouteIs(['price-list']) }}">
                    <a href="{{ action('PriceListController@index') }}" class="black-text">
                        <i class="material-icons">insert_drive_file</i>Прайс лист
                    </a>
                </li>
                <li>
                    <a href="javascript:" onclick="document.getElementById('logout-form').submit()" class="black-text">
                        <i class="material-icons">exit_to_app</i>Выйти
                    </a>
                </li>
            </ul>
        @endauth
    </div>
</nav>

<form action="{{ route('logout') }}" id="logout-form" method="post">@csrf</form>
