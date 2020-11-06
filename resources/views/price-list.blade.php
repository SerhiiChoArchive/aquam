@extends('layouts.app')

@section('title', 'Загрузить прайс лист')

@section('content')

<div class="container" style="margin-top:34px">
    <div class="row">
        <div class="col s12 l6 offset-l3">
            <h5>Обновить прайс лист</h5>
            <p style="padding:10px 0">Выберите прайс лист формата .xlsx и нажмите "Загрузить"</p>

            <form action="{{ action('PriceListController@store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="file-field input-field">
                    <div class="btn transparent grey-text text-darken-4 waves-effect waves-light">
                        <span>Выбрать файл</span>
                        <input type="file" name="file" required>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>

                <div class="input-field">
                    <button class="btn teal darken-2 waves-effect waves-light" type="submit">
                        <i class="material-icons right">file_upload</i>Загрузить
                    </button>
                </div>
            </form>
        </div>

        @if ($diff->hasCategories())
            <div class="col s12" style="padding-top:17px">
                <h5>Новые позиции</h5>
                <p>Обратите внимание! Позиции ниже являются добавленными или удаленными. Либо их не было в прошлом прайс листе, либо из нет в новом.</p>

                <x-price-list-tabs :price="$diff"></x-price-list-tabs>
            </div>
        @endif
    </div>
</div>

@endsection
