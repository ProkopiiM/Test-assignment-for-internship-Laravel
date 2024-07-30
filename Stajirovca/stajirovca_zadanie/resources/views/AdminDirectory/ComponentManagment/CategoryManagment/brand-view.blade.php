@extends('AdminDirectory.layout_admin')
@section('title')
    @if(!empty($brand))
        {{$brand->name}}
    @else
        Добавление категории
    @endif
@endsection
@section('main-content')
    <div>
        <button onclick="window.location.href = '/admin-panel/categories';">
            <iconify-icon icon="ep:back"></iconify-icon>
            Назад
        </button>
        <form id="add-category-form" method="POST"
              @if(!empty($brand))
                  action="{{ route('admin-panel.brands.brand.update') }}"
              @else
                  action="{{ route('admin-panel.brands.brand.add') }}"
            @endif>
            @if(!empty($brand))
                @method('PUT')
                <input hidden="hidden" value="{{$brand->id}}" id="id" name="id">
            @endif
            @csrf
            <h4>@if(!empty($brand))
                    Редактирование '{{$brand->name}}'
                @else
                    Добавление информационной карточки
                @endif</h4>
            <div style="margin-bottom: 20px">
                <h6>Название:</h6>
                <input class="input-details" id="name" disabled="disabled" name="name" type="text" value="{{$brand->name ?? ''}}">
            </div>
            <button id="redact-button" class="btn btn-primary" type="button" onclick="redactCategory()">Редактировать</button>
            <button id="cansel-save" class="btn btn-primary" hidden="hidden" type="button" onclick="canselCategoryRedact()" style="background: gray; border: 1px solid gray;margin-bottom: 20px">Отмена</button>
            <button hidden="hidden" id="save-button" class="btn btn-primary" type="submit">
                @if(!empty($brand))
                    Сохранить
                @else
                    Добавить
                @endif
            </button>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        function redactCategory()
        {
            document.getElementById('name').disabled = false;
            document.getElementById('redact-button').hidden = true;
            document.getElementById('cansel-save').hidden = false;
            document.getElementById('save-button').hidden = false;
        }
        function canselCategoryRedact()
        {
            document.getElementById('name').disabled = false;
            document.getElementById('redact-button').hidden = false;
            document.getElementById('cansel-save').hidden = true;
            document.getElementById('save-button').hidden = true;
        }
        @if(session('set'))
        alert('{{session('set')}}')
        @endif
    </script>
@endsection


