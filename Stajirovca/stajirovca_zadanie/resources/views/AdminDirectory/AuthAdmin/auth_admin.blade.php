@extends('AdminDirectory.layout_admin')
@section('title')
    Авторизация панели администратора
@endsection
@section('main-content')
    <div style="margin-top: 200px" class="centered-form">
        <form method="POST" action="{{ route('admin.store') }}">
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
@endsection
