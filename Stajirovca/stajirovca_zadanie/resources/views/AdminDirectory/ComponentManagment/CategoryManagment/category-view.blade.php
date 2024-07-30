@extends('AdminDirectory.layout_admin')
@section('title')
    @if(!empty($category))
        {{$category->name}}
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
            @if(!empty($category))
                action="{{ route('admin-panel.categories.category.update') }}"
            @else
                action="{{ route('admin-panel.categories.category.add') }}"
            @endif>
            @if(!empty($category))
                @method('PUT')
                <input hidden="hidden" value="{{$category->id}}" id="id" name="id">
            @endif
            @csrf
                <h4>@if(!empty($category))
                        Редактирование '{{$category->name}}'
                    @else
                        Добавление информационной карточки
                    @endif</h4>
                <div>
                    <h6>Название:</h6>
                    <input disabled="disabled" class="input-details" id="name" name="name" type="text" value="{{$category->name ?? ''}}">
                </div>
                <div>
                    <h6>Описание:</h6>
                    <textarea id="description" disabled="disabled" style="border: 1px solid gray; min-width: 50%;border-radius: 4px;" name="description" >
                        {{$category->description ?? ''}}
                    </textarea>
                </div>
                <button id="redact-button" class="btn btn-primary" type="button" onclick="redactCategory()">Редактировать</button>
                <button id="cansel-save" class="btn btn-primary" hidden="hidden" type="button" onclick="canselCategoryRedact()" style="background: gray; border: 1px solid gray;margin-bottom: 20px">Отмена</button>
                <button hidden="hidden" id="save-button" class="btn btn-primary" type="submit">
                    @if(!empty($category))
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
            document.getElementById('description').disabled = false;
            document.getElementById('redact-button').hidden = true;
            document.getElementById('cansel-save').hidden = false;
            document.getElementById('save-button').hidden = false;
        }
        function canselCategoryRedact()
        {
            document.getElementById('name').disabled = false;
            document.getElementById('description').disabled = false;
            document.getElementById('redact-button').hidden = false;
            document.getElementById('cansel-save').hidden = true;
            document.getElementById('save-button').hidden = true;
        }
        @if(session('set'))
        alert('{{session('set')}}')
        @endif
    </script>
@endsection

