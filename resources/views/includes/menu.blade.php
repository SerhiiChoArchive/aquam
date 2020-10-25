@auth
    <li class="{{ active_if_route_is(['dashboard']) }}">
        <a href="{{ action('DashboardController@index') }}">Панель</a>
    </li>
    <li class="{{ active_if_route_is(['update-data']) }}">
        <a href="{{ action('UpdateDataController@index') }}">Обновить данные</a>
    </li>
    <li class="">
        <a href="javascript:" onclick="document.getElementById('logout-form').submit()">Выйти</a>
    </li>
@endauth
