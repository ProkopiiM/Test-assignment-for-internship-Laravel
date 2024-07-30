@extends('AdminDirectory.layout_admin')
@section('title')
    Управление пользователя
@endsection
@section('main-content')
    <div class="products-managment">
        <form id="searchForm" method="GET" action="{{ route('admin-panel.users.index') }}">
            <input onchange="submitForm()" type="text" name="search" class="search-input" placeholder="Поиск" value="{{ request('search') }}">
            <div style="display: flex">
                <div>
                    Роль пользователя:
                    <select name="role" onchange="submitForm()">
                        <option value="all" {{request('role') == 'all' ? 'selected' : ''}}>Любая</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    Сортировка:
                    <select name="sort" onchange="submitForm()">
                        <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>По умолчанию</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>ФИО (А-Я)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>ФИО (Я-А)</option>
                        <option value="role_asc" {{ request('sort') == 'role_asc' ? 'selected' : '' }}>Статус (1-3)</option>
                        <option value="role_desc" {{ request('sort') == 'role_desc' ? 'selected' : '' }}>Статус (3-1)</option>
                        <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Новизна (старые > новые)</option>
                        <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Новизна (новые > старые)</option>
                    </select>
                </div>
                <div>
                    Количество на странице:
                    <select name="paginate" onchange="submitForm()">
                        <option value="15" {{ request('paginate') == '15' ? 'selected' : '' }}>15</option>
                        <option value="25" {{ request('paginate') == '25' ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('paginate') == '50' ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('paginate') == '100' ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </div>
        </form>
        @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->role_id == 1)
            <hr style="margin-top: 25px; margin-bottom: 25px">
            <div style="display: flex">
                <button class="profile-button" onclick="createNewUser()">Добавить пользователя</button>
            </div>
        @endif
        <hr style="margin-top: 25px; margin-bottom: 25px">
        @if(!empty($users))
            <h4>Результаты поиска</h4>
            <div id="search-results" class="grid-view">
                <div style="margin-top: 20px; margin-left: 20px; max-height: 500px; overflow-y: scroll;">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Номер</th>
                            <th>Имя</th>
                            <th>Почта</th>
                            <th>Телефон</th>
                            <th>Роль</th>
                            <th>Дата регистрации</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>{{ $user->created_at }}</td>
                                @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->role_id == 1)
                                    <td>
                                        <form method="GET" id="redact-user-form" action="{{route('admin-panel.users.create')}}">
                                            <input hidden="hidden" name="id" value="{{$user->id}}">
                                            <button class="btn btn-primary" style="margin-bottom: 10px">
                                                <iconify-icon icon="material-symbols:edit"></iconify-icon>
                                            </button>
                                        </form>
                                        <form method="POST" id="delete-user-form" action="{{ route('admin-panel.users.delete') }}">
                                            @method('DELETE')
                                            @csrf
                                            <input hidden="hidden" name="id" value="{{$user->id}}">
                                            <button class="btn btn-primary">
                                                <iconify-icon icon="material-symbols:delete"></iconify-icon>
                                            </button>
                                        </form></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <p>Результатов не найдено.</p>
        @endif
        {{ $users->links() }}
    </div>
@endsection
@section('scripts')
    <script>
        function createNewUser()
        {
            window.location.href = '{{'/admin-panel/user'}}';
        }
        function submitForm() {
            document.getElementById('searchForm').submit();
        }
        @if(session('error'))
            alert('{{session('error')}}')
        @endif
        @if(session('status'))
        alert('{{session('status')}}')
        @endif
    </script>
@endsection
