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
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <form method="GET" id="redact-user-form" action="{{route('admin-panel.categories.category.create')}}">
                                <input hidden="hidden" name="id" value="{{$category->id}}">
                                <button class="btn btn-primary" style="margin-bottom: 10px">
                                    <iconify-icon icon="material-symbols:edit"></iconify-icon>
                                </button>
                            </form>
                            <form method="POST" id="delete-user-form" action="{{ route('admin-panel.categories.category.destroy') }}">
                                @method('DELETE')
                                @csrf
                                <input hidden="hidden" name="id" value="{{$category->id}}">
                                <button class="btn btn-primary">
                                    <iconify-icon icon="material-symbols:delete"></iconify-icon>
                                </button>
                            </form></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <button style="margin-top: 20px;" id="addCategoryButton" onclick="window.location.href = '/admin-panel/categories/category'">Добавление категории товаров</button>
        <hr style="border: 1px solid gray">
        <h6>Бренды:</h6>
        <div style="margin-top: 20px; min-height: 300px; overflow-y: scroll;">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Номер бренда</th>
                    <th>Название</th>
                </tr>
                </thead>
                <tbody>
                @foreach($brands as $brand)
                    <tr>
                        <td>{{ $brand->id }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>
                            <form method="GET" id="redact-user-form" action="{{route('admin-panel.brands.brand.create')}}">
                                <input hidden="hidden" name="id" value="{{$brand->id}}">
                                <button class="btn btn-primary" style="margin-bottom: 10px">
                                    <iconify-icon icon="material-symbols:edit"></iconify-icon>
                                </button>
                            </form>
                            <form method="POST" id="delete-user-form" action="{{ route('admin-panel.brands.brand.destroy') }}">
                                @method('DELETE')
                                @csrf
                                <input hidden="hidden" name="id" value="{{$brand->id}}">
                                <button class="btn btn-primary">
                                    <iconify-icon icon="material-symbols:delete"></iconify-icon>
                                </button>
                            </form></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <button style="margin-top: 20px;" id="addCategoryButton" onclick="
            window.location.href='/admin-panel/brands/brand'">Добавление бренда товаров</button>
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

