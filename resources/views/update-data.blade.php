@extends('layouts.app')

@section('title', 'Загрузить XLS файл')

@section('content')

<div class="container" style="margin-top:34px">
    <div class="row">
        <div class="col s12 l6">
            <p class="flow-text">Прайс лист</p>

            <form action="{{ action('UploadController@upload') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="file-field input-field">
                    <div class="btn teal darken-1 waves-effect waves-light">
                        <span>Выбрать</span>
                        <input type="file" name="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>

                <div class="input-field">
                    <button class="btn teal darken-1 waves-effect waves-light" type="submit">Загрузить</button>
                </div>
            </form>
        </div>

        <div class="col s12 l6">
            <p class="flow-text">Сохранить CSV</p>

            <form action="{{ action('UploadController@uploadImages') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="file-field input-field">
                    <div class="btn teal darken-1 waves-effect waves-light">
                        <span>Выбрать</span>
                        <input type="file" name="images">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>

                <div class="input-field">
                    <button class="btn teal darken-1 waves-effect waves-light" type="submit">Загрузить</button>
                </div>
            </form>
        </div>
    </div>

@endsection
