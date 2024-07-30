@extends('AdminDirectory.layout_admin')
@section('title')
    @if(!empty($card))
        {{$card->title}}
    @else
        Добавление информационной карточки
    @endif
@endsection
@section('main-content')
    <div>
        <button onclick="window.location.href = '/admin-panel/information';">
            <iconify-icon icon="ep:back"></iconify-icon>
            Назад
        </button>
        <form id="card-form" name="card-form" method="POST"
              @if(!empty($card))
                action="{{ route('admin-panel.information.information.update') }}"
              @else
                  action="{{ route('admin-panel.information.information.add') }}"
              @endif>
            @csrf
            @if(!empty($card))
                @method('PUT')
                <input hidden="hidden" value="{{$card->id}}" id="id" name="id">
            @endif
            <div style="margin-top: 20px">
                <h4>@if(!empty($card))
                        Редактирование '{{$card->title}}'
                    @else
                        Добавление информационной карточки
                    @endif</h4>
                <div style="margin-top: 20px">
                    <h6>Название:</h6>
                    <input class="input-details" disabled="disabled" id="title" name="title" value="{{$card->title ?? ''}}">
                </div>
                <div style="margin-top: 20px">
                    <h6>Статус:</h6>
                    <select style="margin-bottom: 20px;border: 1px solid gray;" name="status" id="status" disabled="disabled">
                        <option value="0" {{ (!empty($card) && $card->status == '0') ? 'selected' : ''}}>Неактивен</option>
                        <option value="1" {{ (!empty($card) && $card->status == '1') ? 'selected' : ''}}>Активен</option>
                    </select>
                </div>
                <h6>Описание:</h6>
                <textarea disabled="disabled" id="summernote" name="description">{{$card->description ?? ''}}</textarea>
                <script>
                    $('#summernote').summernote({
                        placeholder: 'Описание',
                        tabsize: 2,
                        height: 400,
                    });
                </script>
                <button id="redact-button" class="btn btn-primary" type="button" onclick="redactCard()">Редактировать</button>
                <button id="cansel-save" class="btn btn-primary" hidden="hidden" type="button" onclick="canselCardRedact()" style="background: gray; border: 1px solid gray;margin-bottom: 20px">Отмена</button>
                <button hidden="hidden" id="save-button" class="btn btn-primary" type="submit">
                    @if(!empty($card))
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
            @if(empty($card))
            document.getElementById('title').disabled = false;
            @endif
            document.getElementById('status').disabled = false;
            document.getElementById('summernote').disabled = false;
            document.getElementById('redact-button').hidden = true;
            document.getElementById('cansel-save').hidden = false;
            document.getElementById('save-button').hidden = false;
        }
        function canselCardRedact()
        {
            @if(empty($card))
            document.getElementById('title').disabled = true;
            @endif
            document.getElementById('summernote').disabled = true;
            document.getElementById('status').disabled = true;
            document.getElementById('redact-button').hidden = false;
            document.getElementById('cansel-save').hidden = true;
            document.getElementById('save-button').hidden = true;
        }
        @if(session('set'))
            alert('{{session('set')}}')
        @endif
    </script>
@endsection
