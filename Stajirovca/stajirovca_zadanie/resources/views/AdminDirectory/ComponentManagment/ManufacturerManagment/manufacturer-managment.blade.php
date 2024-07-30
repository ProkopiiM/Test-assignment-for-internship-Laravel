@extends('AdminDirectory.ComponentManagment.component-managment')
@section('component-content')
    <h4>Категории/Бренды</h4>
    <div>
        <h6>Категории:</h6>
        <div style="margin-top: 20px; min-height: 300px; overflow-y: scroll;">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Номер категории</th>
                    <th>Название</th>
                    <th>Описание</th>
                </tr>
                </thead>
                <tbody>
                @foreach($manufacturers as $manufacturer)
                    <tr>
                        <td>{{ $manufacturer->id }}</td>
                        <td>{{ $manufacturer->name }}</td>
                        <td>
                            <form method="GET" id="redact-manufacturer-form" action="{{route('admin-panel.manufacturers.manufacturer.show',$manufacturer->id)}}">
                                <button class="btn btn-primary" style="margin-bottom: 10px">
                                    <iconify-icon icon="material-symbols:edit"></iconify-icon>
                                </button>
                            </form>
                            <form method="POST" id="delete-manufacturer-form" action="{{ route('admin-panel.manufacturers.manufacturer.destroy',$manufacturer->id) }}">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-primary">
                                    <iconify-icon icon="material-symbols:delete"></iconify-icon>
                                </button>
                            </form></td>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <button style="margin-top: 20px;" id="addCategoryButton" onclick="window.location.href = '/admin-panel/categories/category'">Добавление категории товаров</button>
        <hr style="border: 1px solid gray">
    </div>
@endsection
@section('component-scripts')
    <script>
        function canselButton()
        {
            document.getElementById('addButton').hidden = false;
            document.getElementById('add-to-slider').hidden=true;
        }
        function canselRecommendButton()
        {
            document.getElementById('addRecommendButton').hidden = false;
            document.getElementById('add-to-recommend').hidden=true;
        }
        function scrollProducts(direction) {
            const container = document.getElementById('recommendProducts');
            if (!container) {
                console.error('Element with id "recommendProducts" not found.');
                return;
            }
            const scrollAmount = 300;
            console.log(`Scrolling ${direction > 0 ? 'right' : 'left'} by ${scrollAmount}px`);
            container.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>
@endsection

