@auth
    <li class="{{ App\Helper::activeIfRouteIs(['dashboard']) }}">
        <a href="{{ action('DashboardController@index') }}">Панель</a>
    </li>
    <li class="{{ App\Helper::activeIfRouteIs(['update-data']) }}">
        <a href="{{ action('UpdateDataController@index') }}">Обновить данные</a>
    </li>
    <li class="">
        <a href="javascript:" onclick="document.getElementById('logout-form').submit()">Выйти</a>
    </li>
@endauth
