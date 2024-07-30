@extends('ResetDirectory.email_layout')
@section('title')
    Сброс пароля
@endsection
@section('main-container')
    <div style="display: flex; justify-content: center;">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <label for="password">{{ __('Пароль') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">{{ __('Подтверждение пароля') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    {{ __('Сбросить пароль') }}
                </button>
            </div>
        </form>
    </div>
@endsection
