@extends('AdminDirectory.layout_admin')
@section('title')
    @if(!empty($user))
        Редактирование пользователя
    @else
        Добавление пользователя
    @endif
@endsection
@section('main-content')
    <form id="user-form" method="POST" @if(!empty($user))
        action="{{ route('admin-panel.users.update') }}"
          @else
              action="{{ route('admin-panel.users.store') }}"
        @endif>
        @csrf
        @if(!empty($user))
            @method('PUT')
            <input hidden="hidden" value="{{$user->id}}" id="id" name="id">
        @endif
        <div class="product-details">
            <div style="display: flex">
                <div class="profile-managment-div">
                    <div style="display: flex">
                        <h6 style="width: 50%;margin-right: 20px">ФИО:</h6>
                        <input style="margin-right: 20px" type="text" name="name" id="name" value="{{ $user->name ?? ''}}" disabled="disabled">
                    </div>
                    <div style="display: flex">
                        <h6 style="width: 50%;margin-right: 20px">Почта:</h6>
                        <input style="margin-right: 20px" type="email" name="email" id="email" value="{{$user->email ?? ''}}" disabled="disabled">
                    </div>
                    <div style="display: flex">
                        <h6 style="width: 50%;margin-right: 20px">Телефон:</h6>
                        <input style="margin-right: 20px" type="tel" name="phone" id="phone" value="{{$user->phone ?? ''}}" disabled="disabled">
                    </div>
                    <div style="display: flex;margin-bottom: 20px">
                        <h6 style="width: 50%;margin-right: 20px">Роль:</h6>
                        @if(!empty($user))
                            <input style="margin-right: 20px" name="role" id="role" value="{{$user->role->name ?? ''}}" disabled="disabled">
                        @endif
                        <select hidden="hidden" id="role_id" name="role_id" style="width: 50%;border: 1px solid gray; border-radius: 5px; margin-left: 20px" onchange="categoryChange()">
                            @foreach($roles as $role)
                                <option value="{{$role->id}}" {{ ($role->role_id ?? '') == $role->id ? 'selected' : '' }}>{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(empty($user) || Auth::guard('admin')->user()->id == $user->id)
                        <div style="display: flex">
                            <h6 style="width: 50%;margin-right: 20px">Пароль:</h6>
                            <div>
                                <input style="margin-right: 20px" type="password" name="password" id="password" disabled="disabled">
                                <input style="margin-right: 20px" type="password" name="password_confirmation" id="password_confirmation" disabled="disabled">
                            </div>
                        </div>
                    @endif
            </div>
        </div>
        <button id="redact-button" class="btn btn-primary" type="button" onclick="redactProduct()">Редактировать</button>
        <button id="cansel-save" class="btn btn-primary" hidden="hidden" type="button" onclick="canselRedact()" style="background: gray; border: 1px solid gray;margin-bottom: 20px">Отмена</button>
        <button hidden="hidden" id="save-button" class="btn btn-primary" type="submit">
            @if(!empty($user))
                Сохранить
            @else
                Добавить
            @endif
        </button>
        </div>
    </form>
@endsection
@section('scripts')
    <script>
        function redactProduct()
        {
            document.getElementById('name').disabled = false;
            document.getElementById('email').disabled = false;
            document.getElementById('phone').disabled = false;
            document.getElementById('role_id').hidden = false;
            @if(empty($user) || Auth::guard('admin')->user()->id == $user->id)
            document.getElementById('password_confirmation').disabled = false;
            document.getElementById('password').disabled = false;
            @endif
            document.getElementById('redact-button').hidden = true;
            document.getElementById('save-button').hidden = false;
            document.getElementById('cansel-save').hidden = false;
        }
        function canselRedact()
        {
            document.getElementById('name').disabled = true;
            document.getElementById('email').disabled = true;
            document.getElementById('phone').disabled = true;
            document.getElementById('role_id').hidden = true;
            @if(empty($user) || Auth::guard('admin')->user()->id == $user->id)
            document.getElementById('password_confirmation').disabled = false;
            document.getElementById('password').disabled = false;
            @endif
            document.getElementById('redact-button').hidden = false;
            document.getElementById('save-button').hidden = true;
            document.getElementById('cansel-save').hidden = true;
        }
        const phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('input', function(event) {
            const input = event.target.value.replace(/\D/g, '').substring(0, 11);
            const phoneFormat = '+7 (' + input.substring(1, 4) + ') ' + input.substring(4, 7) + '-' + input.substring(7, 9) + '-' + input.substring(9, 11);
            event.target.value = phoneFormat;
        });
    </script>
@endsection
