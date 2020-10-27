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
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3">
                        <a class="active" href="#fish">Рыба <b>({{ $count_fish }})</b></a>
                    </li>
                    <li class="tab col s3">
                        <a href="#equipment">Оборудывание <b>({{ $count_equipment }})</b></a>
                    </li>
                    <li class="tab col s3">
                        <a href="#feed">Корма <b>({{ $count_feed }})</b></a>
                    </li>
                    <li class="tab col s3">
                        <a href="#chemistry">Химия <b>({{ $count_chemistry }})</b></a>
                    </li>
                </ul>
            </div>

            <div id="fish" class="col s12">
                @include('includes.fish')
            </div>
            <div id="equipment" class="col s12">

            </div>
            <div id="feed" class="col s12">

            </div>
            <div id="chemistry" class="col s12">

            </div>
        </div>
    </div>
@endsection

