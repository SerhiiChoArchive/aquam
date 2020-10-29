@extends('layouts.app')

@section('title', 'Загрузить XLS файл')

@section('content')
    <div class="container" style="margin-top:20px">
        <div class="row">
            <div class="col s12 m6">
                <table class="striped">
                    <tbody>
                    <tr>
                        <td>Последнее обновление прайса</td>
                        <td>{{ $last_upload ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Последний визит в приложение</td>
                        <td>{{ $last_request ?? '' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row" style="margin-top: 30px">
            <div class="col s12" style="margin-bottom: 10px">

            <x-price-list-tabs :price="$price"></x-price-list-tabs>
        </div>
    </div>
@endsection

