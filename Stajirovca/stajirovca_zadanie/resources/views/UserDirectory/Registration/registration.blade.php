@extends('layout')
@section('title')
    Регистрация
@endsection
@section('main-content')
    <div class="main-registration-div">
        <h4 style="margin-bottom: 20px">Регистрация</h4>
        <h5>Информация о пользователе</h5>
        <form id="registration-form" name="registration-form" method="POST" action="{{route('registration.store')}}">
            @csrf
            <p class="required-info">* Поля, помеченные звездочкой, являются обязательными для заполнения.</p>
            <div class="registration-fields">
                <div class="registration-div">
                    <div>
                        <h6>* ФИО</h6>
                        <input placeholder="Иванов Иван Иванович" type="text" id="name" name="name" value="{{old('name') ?? ''}}">
                        @error('name')
                        <span class="error" id="phoneError">{{$message}}</span>
                        @enderror
                    </div>
                    <div>
                        <h6>* Телефон</h6>
                        <input placeholder="+7(999)999-99-99" type="tel" id="phone" name="phone" value="{{old('phone')  ?? ''}}">
                        @error('phone')
                        <span class="error" id="phoneError">{{$message}}</span>
                        @enderror
                    </div>
                    <div>
                        <h6>* Почта</h6>
                        <input placeholder="name@mail.ru" type="email" id="email" name="email" value="{{old('email')  ?? ''}}">
                        @error('email')
                        <span class="error" id="phoneError">{{$message}}</span>
                        @enderror
                    </div>
                    <div>
                        <h6>* Пароль</h6>
                        <input placeholder="******" type="password" id="password" name="password">
                        @error('password')
                        <span class="error" id="phoneError">{{$message}}</span>
                        @enderror
                    </div>
                    <div>
                        <h6>* Подтвердите пароль</h6>
                        <input placeholder="******" type="password" id="password_confirmation" name="password_confirmation">
                        @error('password')
                        <span class="error" id="phoneError">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div>
                <button style="margin-top: 20px;margin-left: 0px;" type="submit" class="profile-button">Зарегистрироваться</button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        @if(session('error'))
            alert('{{ session('error') }}');
        @endif
        const phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('input', function(event) {
            const input = event.target.value.replace(/\D/g, '').substring(0, 11);
            const phoneFormat = '+7 (' + input.substring(1, 4) + ') ' + input.substring(4, 7) + '-' + input.substring(7, 9) + '-' + input.substring(9, 11);
            event.target.value = phoneFormat;
        });
    </script>
@endsection
