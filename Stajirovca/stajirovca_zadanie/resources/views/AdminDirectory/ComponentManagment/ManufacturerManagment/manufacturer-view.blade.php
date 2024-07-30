@extends('AdminDirectory.layout_admin')
@section('title')
    @if(!empty($manufacturer))
        {{$manufacturer->name}}
    @else
        Добавление производителя
    @endif
@endsection
@section('main-content')
    <div>
        <button onclick="window.location.href = '/admin-panel/manufacturers';">
            <iconify-icon icon="ep:back"></iconify-icon>
            Назад
        </button>
        <form id="card-form" name="card-form" method="POST"
              @if(!empty($manufacturer))
                  action="{{ route('admin-panel.manufacturers.manufacturer.update',$manufacturer->id) }}"
              @else
                  action="{{ route('admin-panel.manufacturers.manufacturer.add') }}"
            @endif>
            @csrf
            @if(!empty($manufacturer))
                @method('PUT')
            @endif
            <div style="margin-top: 20px">
                <h4>@if(!empty($manufacturer))
                        Редактирование '{{$manufacturer->name}}'
                    @else
                        Добавление информационной карточки
                    @endif</h4>
                <div style="margin-top: 20px">
                    <h6>Название:</h6>
                    <input class="input-details" disabled="disabled" id="title" name="title" value="{{$manufacturer->name ?? ''}}">
                </div>
                <button id="redact-button" class="btn btn-primary" type="button" onclick="redactCard()">Редактировать</button>
                <button id="cansel-save" class="btn btn-primary" hidden="hidden" type="button" onclick="canselCardRedact()" style="background: gray; border: 1px solid gray;margin-bottom: 20px">Отмена</button>
                <button hidden="hidden" id="save-button" class="btn btn-primary" type="submit">
                    @if(!empty($manufacturer))
                        Сохранить
                    @else
                        Добавить
                    @endif
                </button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        function redactCard()
        {
            document.getElementById('title').disabled = false;
            document.getElementById('redact-button').hidden = true;
            document.getElementById('cansel-save').hidden = false;
            document.getElementById('save-button').hidden = false;
        }
        function canselCardRedact()
        {
            document.getElementById('title').disabled = true;
            document.getElementById('redact-button').hidden = false;
            document.getElementById('cansel-save').hidden = true;
            document.getElementById('save-button').hidden = true;
        }
        @if(session('set'))
        alert('{{session('set')}}')
        @endif
    </script>
@endsection
