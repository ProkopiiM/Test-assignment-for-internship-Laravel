@extends('AdminDirectory.layout_admin')
@section('title')
    Управление компонентами
@endsection
@section('main-content')
    <div style="display: flex;">
        <div class="profile-nav" style="margin-right: 20px">
            <ul class="nav-list">
                <h4>Управление компонентами</h4>
                <li><a href="/admin-panel/categories" class="nav-item">Добавление категорий/брендов</a></li>
                <li><a href="/admin-panel/information" class="nav-item">Управление информационной панелью</a></li>
                <li><a href="/admin-panel/main-layout" class="nav-item">Управление главной страницей</a></li>
                <li><a href="/admin-panel/review" class="nav-item">Управление отзывами</a></li>
                <li><a href="/admin-panel/manufacturers" class="nav-item">Управление производителями</a></li>
            </ul>
        </div>
        <div style="margin-top: 20px; margin-left: 20px">
            @yield('component-content')
        </div>
    </div>
@endsection
@section('scripts')
    @yield('component-scripts')
@endsection
