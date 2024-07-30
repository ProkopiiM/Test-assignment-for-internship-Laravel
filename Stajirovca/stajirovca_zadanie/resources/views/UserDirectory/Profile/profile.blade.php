@extends('layout')
@section('title')
    Профиль
@endsection
@section('main-content')
    <h1>Профиль</h1>
    <div style="display: flex;">
        <div class="profile-nav">
            <ul class="nav-list">
                <h4>Личная информация</h4>
                <li><a href="/profile" class="nav-item">Главная</a></li>
                <li><a href="/profile/user-data" class="nav-item">Данные пользователя</a></li>
                <li><a href="/profile/order-history" class="nav-item">История заказов</a></li>
                <li><button name="logout-button" id="logout-button" class="nav-item logout-button" onclick="logoutRedirect()">Выход</button></li>
            </ul>
        </div>
        <div>
            @yield('profile-content')
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function logoutRedirect() {
            window.location.href = "{{ route('logout.index') }}";
        }
    </script>
    @yield('profile-scripts')
@endsection
