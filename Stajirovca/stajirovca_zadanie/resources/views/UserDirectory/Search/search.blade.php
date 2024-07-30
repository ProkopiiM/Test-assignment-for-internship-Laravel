@extends('layout')
@section('title')
    Поиск
@endsection
@section('main-content')
    <div class="products-managment">
        <form id="searchForm" method="GET" action="{{ route('search.index') }}">
            <input onchange="submitForm()" type="text" name="search" class="search-input" placeholder="Поиск" value="{{ request('search') }}">
            <div style="display: flex">
                <div>
                    Категории:
                    <select name="category" onchange="submitForm()">
                        <option value="">Все категории</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    Сортировка:
                    <select name="sort" onchange="submitForm()">
                        <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>По умолчанию</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Название (А-Я)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Название (Я-А)</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Цена (низкая > высокая)</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цена (высокая > низкая)</option>
                        <option value="rating_asc" {{ request('sort') == 'rating_asc' ? 'selected' : '' }}>Рейтинг (низкий > высокий)</option>
                        <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Рейтинг (высокий > низкий)</option>
                        <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Новизна (старые > новые)</option>
                        <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Новизна (новые > старые)</option>
                        <option value="popularity_asc" {{ request('sort') == 'popularity_asc' ? 'selected' : '' }}>Популярность (низкая > высокая)</option>
                        <option value="popularity_desc" {{ request('sort') == 'popularity_desc' ? 'selected' : '' }}>Популярность (высокая > низкая)</option>
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
            <div style="display: flex">
                <div>
                    Рейтинг:
                    <select style="width: 50%; border: 1px solid gray; border-radius: 5px" name="rating" onchange="submitForm()">
                        <option value="0" {{ request('rating') == '0' ? 'selected' : '' }}>0</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5</option>
                    </select>
                </div>
                <div style="display: flex">
                    Цена:
                    <input onchange="submitForm()" style="padding: 5px" type="text" onkeypress="return /[0-9]/i.test(event.key)"  name="min-price" min="0" placeholder="от" value="{{request('min-price')}}">
                    <input onchange="submitForm()" style="padding: 5px" type="text" onkeypress="return /[0-9]/i.test(event.key)"  name="max-price" min="0" placeholder="до" value="{{request('max-price')}}">
                </div>
                <div>
                    Производитель:
                    <select style="width: 50%; border: 1px solid gray; border-radius: 5px" name="manufacturer" onchange="submitForm()">
                        <option value="all" {{request('manufacturer') == 'all' ? 'selected': ''}}>Все</option>
                        @foreach($manufacturers as $manufacturer)
                            <option value="{{$manufacturer->id}}" {{request('manufacturer') == $manufacturer->id ? 'selected' : ''}}>{{$manufacturer->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    В наличии:
                    <select style="width: 50%; border: 1px solid gray; border-radius: 5px" name="is_set" onchange="submitForm()">
                        <option value="all" {{request('is_set') == 'all' ? 'selected': ''}}>Все</option>
                        <option value="yes" {{request('is_set') == 'yes' ? 'selected': ''}}>Есть</option>
                        <option value="no" {{request('is_set') == 'no' ? 'selected': ''}}>Нет</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="view-toggle">
        <button onclick="setGridView()">
            <iconify-icon icon="mingcute:grid-fill"></iconify-icon>
        </button>
        <button onclick="setListView()">
            <iconify-icon icon="material-symbols:list"></iconify-icon>
        </button>
    </div>
    <hr style="margin-top: 25px; margin-bottom: 25px">
    @if($products->count())
        <h4>Результаты поиска</h4>
        <div id="search-results" class="grid-view">
            @foreach($products as $product)
                <div class="product-item">
                    <div class="product-image">
                        <a href="{{ route('product.index','id='. $product->id) }}">
                            <img src="{{ asset('images/' . $product->main_image) }}" alt="{{ $product->name }}">
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('product.index', 'id='.$product->id) }}">{{ $product->name }}</a>
                        @if($product->discount > 0)
                            @php
                                $originalPrice = $product->price;
                                $discountedPrice = $originalPrice - ($originalPrice * ($product->discount / 100));
                            @endphp
                            <p class="discounted-price">{{ number_format($discountedPrice, 2, ',', ' ') }} р.</p>
                            <p class="original-price">{{ number_format($originalPrice, 2, ',', ' ') }} р.</p>
                        @else
                            <p>{{ $product->price }}р.</p>
                        @endif
                        @if($product->quantity >0)
                            <form id="backet-form" method="POST" action="{{ route('backet.store') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button class="submit-button" type="submit">Добавить</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Результатов не найдено.</p>
    @endif
    {{ $products->links() }}
@endsection
@section('scripts')
    <script>
        function submitForm() {
            document.getElementById('searchForm').submit();
        }
        document.addEventListener('DOMContentLoaded', () => {
            const view = localStorage.getItem('view');
            if (view === 'list') {
                setListView();
            } else {
                setGridView();
            }
        });

        function setGridView() {
            const container = document.getElementById('search-results');
            container.classList.remove('list-view');
            container.classList.add('grid-view');
            localStorage.setItem('view', 'grid');
        }

        function setListView() {
            const container = document.getElementById('search-results');
            container.classList.remove('grid-view');
            container.classList.add('list-view');
            localStorage.setItem('view', 'list');
        }

    </script>
@endsection
