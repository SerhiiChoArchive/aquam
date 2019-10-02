@extends('layouts.app')

@section('content')

<div class="container">
    <p class="flow-text center">Войти в панель управления</p>

    <div class="row">
        <div class="col s12 l6 offset-l3">
            <form method="POST" action="{{ route('login') }}">
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

                <div class="input-field">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                </div>

                <button type="submit" class="btn">Войти</button>
            </form>
        </div>
    </div>
</div>

@endsection
