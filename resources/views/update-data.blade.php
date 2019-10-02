@extends('layouts.app')

@section('title', 'Загрузить XLS файл')

@section('content')

<div class="container" style="margin-top:34px">
    <div class="row">
        <div class="col s12 l6">
            <h5>Обновить прайс лист</h5>
            <p style="padding:10px 0">Выберите прайс лист формата .xls и нажмите "Обновить прайс лист"</p>

            <form action="{{ action('UploadController@upload') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="file-field input-field">
                    <div class="btn transparent grey-text text-darken-4 waves-effect waves-light">
                        <span>Выбрать файл</span>
                        <input type="file" name="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>

                <div class="input-field">
                    <button class="btn teal darken-2 waves-effect waves-light" type="submit">Обновить прайс лист</button>
                </div>
            </form>
        </div>

        <div class="col s12 l6">
            <h5>Загрузить csv файл</h5>
            <p style="padding:10px 0">Выберите файл формата .csv и нажмите "Загрузить csv файл" чтобы загрузить файл на сервер. При следующем обновлении прайс листа, ссылки к изображениям в этом файле будут применены к позициям по названию рыбы</p>

            <form action="{{ action('UploadController@uploadImages') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="file-field input-field">
                    <div class="btn transparent grey-text text-darken-4 waves-effect waves-light">
                        <span>Выбрать файл</span>
                        <input type="file" name="images">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>

                <div class="input-field">
                    <button class="btn teal darken-2 waves-effect waves-light" type="submit">Загрузить csv файл</button>
                </div>
            </form>
        </div>

        @if (count($diff_items) > 0)
            <div class="col s12" style="padding-top:17px">
                <h5>Новые позиции</h5>
                <p>Эти названия позиций небыли найдены на прошлом прайс листе</p>

                <table class="striped responsive-table">
                    <thead>
                        <tr>
                            <th>Номер</th>
                            <th>Название</th>
                            <th>Цена</th>
                            <th>Размер</th>
                            <th>Изображение</th>
                        </tr>
                    </thead>
                    <tbody class="striped">
                        @foreach ($diff_items as $item)
                            <tr>
                                <td>{{ $item->number }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->size }}</td>
                                <td><img src="{{ $item->image ?? '' }}" width="120" class="z-depth-1" style="border-radius:3px"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection
