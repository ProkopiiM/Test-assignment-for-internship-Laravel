@extends("ResetDirectory.email_layout")
@section("title")
    Восстановление пароля
@endsection
@section("main-container")
    <div class="centered-form">
        <h1 style="padding-left: 60px">Восстановление пароля</h1>
        Введите почту для восстановления пароля.
    </div>
    <div class="centered-form">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    {{ __('Продолжить') }}
                </button>
            </div>
        </form>
        <div class="form-group">
            <button onclick="redirect()">
                <iconify-icon icon="ep:back"></iconify-icon>
                {{ __('Назад') }}
            </button>
        </div>
    </div>
@endsection
@section('script')
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
            alert('{{ $error }}');
            @endforeach
        </script>
    @endif
    @if (session('status'))
        <script>
            alert('{{ session('status') }}');
        </script>
    @endif
    <script>
        function redirect()
        {
            window.location.href = "{{ route('login.index') }}";
        }
    </script>
@endsection
