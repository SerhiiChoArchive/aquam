@auth
    <li class="{{ active_if_route_is(['/']) }}"><a href="/">Панель</a></li>
    <li class="{{ active_if_route_is(['update-data']) }}"><a href="/update-data">Обновить данные</a></li>
    <li class=""><a href="javascript:" onclick="document.getElementById('logout-form').submit()">Выйти</a></li>
@endauth
