@extends('layout')
@section('title')
Авторизация
@endsection
@section('main-content')
    <div class="centered-form">
        <h1>Авторизация</h1>
        Введите почту и пароль для входа.
    </div>
    <div class="centered-form">
        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>
            <div class="form-group">
                <label for="password">{{ __('Пароль') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            </div>
            @if(!empty($error))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $error }}</strong>
                </span>
            @endif
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    {{ __('Войти') }}
                </button>
            </div>
        </form>
    </div>
    <div class="centered-form-alter">
        <h6>Регистрация:</h6>
        <button name="registration-button" id="registration-button" onclick="registrationRedirect()" class="profile-button">Регистрация</button>
    </div>
    <div class="centered-form-alter">
        <a href="password/email">Восстановить пароль</a>
    </div>
@endsection
@section('scripts')
    <script>
        function registrationRedirect()
        {
            window.location.href = "{{ route('registration.index') }}";
        }
        @if(!empty(session('error')))
            alert('{{session('error')}}')
        @endif
    </script>
@endsection
