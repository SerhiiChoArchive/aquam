@extends('layout')

@section('title', 'Загрузить XLS файл')

@section('content')
    <div class="container" style="margin-top:34px">
        <div class="center">
            <img src="{{ asset('images/logo-aqua.png') }}" alt="aqua-m" width="140">
        </div>

        <div class="row">
            <div class="col s12 l6">
                <form action="{{ action('UploadController@upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="file-field input-field">
                        <div class="btn btn-small teal darken-1">
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
                        <button class="btn teal darken-1" style="display:block;width:100%" type="submit">Загрузить</button>
                    </div>
                </form>
            </div>

            <div class="col s12 l6" style="padding-top:20px">
                @if ($last_upload)
                    <table>
                        <tbody>
                            <tr>
                                <td>Последнее обновление:</td>
                                <td>{{ $last_upload }}</td>
                            </tr>
                            <tr>
                                <td>Все визиты на прайс лист:</td>
                                <td>{{ cache()->get('visits') }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection

