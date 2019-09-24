@extends('layout')

@section('title', 'Загрузить XLS файл')

@section('content')
    <div class="container" style="margin-top:34px">
        <div class="center">
            <img src="{{ asset('images/logo-aqua.png') }}" alt="aqua-m" width="170">
        </div>

        <div class="row">
            <div class="col s12 l6">
                <form action="{{ action('UploadController@upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="file-field input-field">
                        <div class="btn btn-small teal darken-1 waves-effect waves-light">
                            <span>Выбрать</span>
                            <input type="file" name="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>

                    <div class="input-field">
                        <input type="password" name="password" id="password" placeholder="Пароль" required>
                    </div>

                    <div class="input-field">
                        <button class="btn teal darken-1 waves-effect waves-light" style="display:block;width:100%" type="submit">Загрузить</button>
                    </div>
                </form>

                <table style="margin-top:40px" class="striped responsive-table">
                    <tbody>
                        <tr>
                            <td>Последнее обновление:</td>
                            <td>{{ $last_upload ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Последний визит:</td>
                            <td>{{ $last_request ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Все визиты:</td>
                            <td>{{ cache()->get('all_requests') }}</td>
                        </tr>
                        <tr>
                            <td>Визиты за сегодня:</td>
                            <td>{{ cache()->get('requests_today') }}</td>
                        </tr>
                        <tr>
                            <td>Количество категорий:</td>
                            <td>{{ $price_categories_amount }}</td>
                        </tr>
                        <tr>
                            <td>Количество позиций:</td>
                            <td>{{ $price_items_amount }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col s12 l6" style="padding-top:50px">
                <ul class="collapsible">
                    @forelse ($price_list as $category => $items)
                        <li>
                            <div class="collapsible-header">
                                <b class="teal-text darken-4" style="margin-right:5px">{{ count($items) }}</b>
                                {{ $category }}
                            </div>

                            <div class="collapsible-body">
                                <table class="striped responsive-table">
                                    <thead>
                                        <tr>
                                            <th>Номер</th>
                                            <th>Название</th>
                                            <th>Размер</th>
                                            <th>Цена</th>
                                        </tr>
                                    </thead>
                                    <tbody class="striped">
                                        @foreach ($items as $item)
                                            <tr>
                                                <td>{{ $item->number }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->size }}</td>
                                                <td>{{ $item->price }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </li>
                    @empty
                        <div class="collapsible-header"><p class="flow-text">Пусто</p></div>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection

