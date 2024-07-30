@extends('UserDirectory.Profile.profile')
@section('profile-content')
    <h4 style="margin-top: 20px; margin-left: 20px">Личные данные</h4>
    <div class="profile-data-div">
        <form method="POST" action="{{ route('profile.update') }}" id="profile-edit-form">
            @csrf
            @method('PUT')
            <input hidden="hidden" name="id" value="{{$user->id}}"></input>
            <div style="display: flex">
                <div>
                    <h6>ФИО</h6>
                    <input placeholder="ФИО" id="name" name="name" disabled="disabled" value="{{$user->name ?? old('name')}}">
                    @error('name')
                        <span style="max-width: 100px;" class="error" id="phoneError">{{$message}}</span>
                    @enderror
                </div>
                <div>
                    <h6>Телефон</h6>
                    <input placeholder="телефон" type="tel" id="phone" name="phone" disabled="disabled" value="{{$user->phone ?? old('phone') }}">
                    @error('phone')
                    <span style="max-width: 100px;" class="error" id="phoneError">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div style="display: flex">
                <div>
                    <h6>Почта</h6>
                    <input placeholder="почта" type="email" id="email" name="email" disabled="disabled" value="{{$user->email ?? old('email')}}">
                    @error('email')
                    <span style="max-width: 100px;" class="error" id="phoneError">{{$message}}</span>
                    @enderror
                </div>
                <div>
                    <h6>Пароль</h6>
                    <input style="width: 50%" placeholder="******" type="password" id="password" name="password" disabled="disabled">
                    <input style="width: 50%" placeholder="******" type="password" id="password_confirmation" name="password_confirmation" disabled="disabled">
                    <div>
                        @error('password')
                        <span style="max-width: 100px;" class="error" id="phoneError">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div style="display: flex">
                <div style="flex-grow: 0.5;"></div>
                <button id="redaction_button" class="profile-button" type="button" onclick="redactProfile()">Редактировать</button>
                <div style="display: flex">
                    <button id="cansel_button" class="profile-button" style="background: gray" type="button" hidden="hidden" onclick="canselButton()">Отмена</button>
                    <button id="save_button" class="profile-button" hidden="hidden" type="submit">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('profile-scripts')
    <script>
        function redactProfile()
        {
            document.getElementById('name').disabled = false;
            document.getElementById('email').disabled = false;
            document.getElementById('phone').disabled = false;
            document.getElementById('password').disabled = false;
            document.getElementById('password_confirmation').disabled = false;
            document.getElementById('redaction_button').hidden = true;
            document.getElementById('save_button').hidden = false;
            document.getElementById('cansel_button').hidden = false;
        }
        function canselButton(){
            document.getElementById('name').disabled = true;
            document.getElementById('email').disabled = true;
            document.getElementById('phone').disabled = true;
            document.getElementById('password').disabled = true;
            document.getElementById('password_confirmation').disabled = true;
            document.getElementById('redaction_button').hidden = false;
            document.getElementById('save_button').hidden = true;
            document.getElementById('cansel_button').hidden = true;
        }
    </script>
@endsection
