@extends('layouts.app')

@section('title', 'Загрузить изображения')

@section('content')

<div class="container" style="margin-top:34px">
    <div class="row">
        <div class="col s12 l6 offset-l3">
            <h5>Загрузить csv файл</h5>
            <p style="padding:10px 0">Выберите файл формата .csv и нажмите "Загрузить csv файл" чтобы загрузить файл на сервер. При следующем обновлении прайс листа, ссылки к изображениям в этом файле будут применены к соответствующим позициям</p>

            <form action="{{ action('ImagesController@store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="file-field input-field">
                    <div class="btn transparent grey-text text-darken-4 waves-effect waves-light">
                        <span>Выбрать файл</span>
                        <input type="file" name="images">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" required>
                    </div>
                </div>
                
                <div>
                    <label for="file-type">Выберите категорию к которой принадлежат загружаемые изображения</label>
                    <select id="file-type" name="file-type" class="browser-default" required>
                        <option value="fish">Рыба</option>
                        <option value="equipment">Оборудывание</option>
                        <option value="feed">Корма</option>
                        <option value="chemistry">Химия</option>
                        <option value="aquariums">Аквариумы</option>
                    </select>
                </div>

                <div class="input-field">
                    <button class="btn teal darken-2 waves-effect waves-light" type="submit">
                        <i class="material-icons right">file_upload</i>Загрузить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
