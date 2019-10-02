@extends('layouts.app')

@section('content')

<div class="container">
    <p class="flow-text center" style="padding-top:13px">Войти в панель управления</p>

    <div class="row">
        <div class="col s12 m6 offset-m3 l4 offset-l4">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-field">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required class="validate">
                    <label for="email">Ел. адрес</label>
                    @error('email')
                        <span class="helper-text" data-error="wrong" data-success="right">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-field">
                    <input id="password" type="password" name="password" required>
                    <label for="password">Пароль</label>
                    @error('password')
                        <span class="helper-text" data-error="wrong" data-success="right">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-field" style="padding:15px 0">
                    <div class="switch">
                        <label>
                            Не запоминать меня
                            <input type="checkbox" {{ old('remember') ? 'checked' : '' }} name="remember">
                            <span class="lever"></span>
                            Запомнить меня
                        </label>
                    </div>
                </div>

                <div class="input-field">
                    <button type="submit" class="btn teal darken-1">Войти</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
