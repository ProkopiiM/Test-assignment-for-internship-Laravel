@extends('AdminDirectory.ComponentManagment.component-managment')
@section('component-content')
    <h4>Иформационная панель</h4>
    <button style="margin-top: 20px;margin-bottom: 20px;border: 1px solid gray;border-radius: 4px;" onclick="window.location.href='/admin-panel/information/card'">Добавление информационной карточки</button>
    <div>
        <div id="search-results" class="grid-view">
            <div style="margin-top: 20px; min-height: 500px; overflow-y: scroll;">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Номер карточки</th>
                        <th>Название</th>
                        <th>Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cards as $card)
                        <tr>
                            <td>{{ $card->id }}</td>
                            <td>{{ $card->title }}</td>
                            @if($card->status == 0)
                                <td>Неактивен</td>
                            @else
                                <td>Активен</td>
                            @endif
                            <td>
                                <form method="GET" id="redact-user-form" action="{{route('admin-panel.information.information.create')}}">
                                    <input hidden="hidden" name="id" value="{{$card->id}}">
                                    <button class="btn btn-primary" style="margin-bottom: 10px">
                                        <iconify-icon icon="material-symbols:edit"></iconify-icon>
                                    </button>
                                </form>
                                <form method="POST" id="delete-user-form" action="{{ route('admin-panel.information.information.destroy') }}">
                                    @method('DELETE')
                                    @csrf
                                    <input hidden="hidden" name="id" value="{{$card->id}}">
                                    <button class="btn btn-primary">
                                        <iconify-icon icon="material-symbols:delete"></iconify-icon>
                                    </button>
                                </form></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

