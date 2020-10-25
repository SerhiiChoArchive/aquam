@extends('layouts.app')

@section('content')
    <div class="container">
        <p class="flow-text center" style="padding-top:13px">Регистрация</p>

        <div class="row">
            <div class="col s12 m6 offset-m3 l4 offset-l4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="input-field">
                        <input id="name" type="text" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        <label for="name">{{ __('Name') }}</label>

                        @error('name')
                            <span class="helper-text red-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-field">
                        <label for="email">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="helper-text red-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-field">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="helper-text red-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-field">
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="input-field">
                        <button type="submit" class="btn teal darken-2">{{ __('Register') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
