@extends('layout')

@section('title', 'Загрузить XLS файл')

@section('content')
    <div class="container">
        <p><img src="{{ asset('images/logo-aqua.png') }}" alt="aqua-m" width="140"></p>

        <form action="{{ action('UploadController@upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-field">
                <label class="input-upload-label" for="input-file" data-title="✚ Выбрать XLS файл">
                    <input type="file" name="file" id="input-file" required>
                </label>

                <small class="input-upload-file-path">
                    <b id="file-path"></b>
                </small>
            </div>
            <div class="input-field">
                <input type="password" name="password" id="password" placeholder="Пароль" required>
            </div>
            <button type="submit">Загрузить</button>
        </form>

        {{-- Alert messages --}}
        <div>
            @if (session('error'))
                <div class="message message-error">{{ session('error') }}</div>
            @elseif (session('success'))
                <div class="message message-success">{{ session('success') }}</div>
            @endif
        </div>
    </div>
@endsection

