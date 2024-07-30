@extends('layout')
@section('title')
    {{$product->name}}
@endsection
@section('main-content')
    <div style="display: flex">
        <div class="product-page">
            <div class="product-images">
                <div class="main-image">
                    <a href="{{ asset('images/' . $product->main_image) }}" data-lightbox="product-images">
                        <img style="max-width: 150px; max-height: 150px" id="mainImage" src="{{ asset('images/' . $product->main_image) }}" alt="{{ $product->name }}">
                    </a>
                </div>
                <div class="thumbnail-images">
                    @foreach ($product->images as $image)
                        <a href="{{ asset('images/' . $image->photo_path) }}" data-lightbox="product-images">
                            <img style="max-width: 50px; max-height: 50px" src="{{ asset('images/' . $image->photo_path) }}" alt="{{ $product->name }}" onclick="changeMainImage('{{ asset('images/' . $image->photo_path) }}')">
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div style="flex-grow: 1;"></div>
        <div class="product-details">
                <h1>{{ $product->name }}</h1>
                @if($product->discount > 0)
                <div
                style="display: flex">
                    <h6>Цена:</h6>
                    <p class="price" style="color: green">{{ ($product->price - ($product->price * ($product->discount / 100))) }}р.</p>
                    <p class="price" style="color: gray; font-size: 10px">{{ $product->price }}р.</p>
                </div>
                @else
                <h6>Цена:</h6>
                <p class="price">{{ $product->price }}р.</p>
                @endif

                <div style="display: flex">
                    <h6>Рейтинг:</h6>
                    <p> {{round($product->reviews_avg_star,2)}}</p>
                </div>
                <div style="display: flex">
                    <h6>Производитель:</h6>
                    <p> {{$product->manufacture()->paginate(10)->items()[0]->name}}</p>
                </div>
            <div style="display: flex">
                <h6>Производитель:</h6>
                <p> {{$product->brand()->paginate(10)->items()[0]->name ?? ''}}</p>
            </div>
                <form method="POST" action="{{ route('backet.store') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-primary">Добавить в корзину</button>
                </form>
        </div>
    </div>
    <div>
        <h6>Описание: </h6>
        <div>{!!$product->description!!}</div>
    </div>
        <div>
            <h3>Технические характеристики</h3>
            <ul class="specs">
                @foreach ($product->attributes_with_names as $attribute)
                    <li>{{ $attribute['name'] }}: {{ $attribute['value'] }}</li>
                @endforeach
            </ul>
        </div>
        <div class="product-reviews">
                <div
                style="display: flex">
                    <h3>Отзывы покупателей</h3>
                    <div style="flex-grow: 1;"></div>
                    <div style="display: flex">
                        Кол-во отзывов:
                        <form id="paginate-form" type="get" action="{{route('product.index')}}">
                            <input hidden="hidden" type="text" name="id" value="{{$product->id}}">
                            <select name="paginate" style="border: 1px solid gray; border-radius: 5px" onchange="submitForm()">
                                <option value="15" {{ request('paginate') == '15' ? 'selected' : '' }}>15</option>
                                <option value="25" {{ request('paginate') == '25' ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('paginate') == '50' ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('paginate') == '100' ? 'selected' : '' }}>100</option>
                            </select>
                        </form>
                    </div>
                </div>
                @if(!empty($reviews->items()))
                    @php
                    $i=0; @endphp
                    @foreach ($reviews->items() as $review)
                        @if($review['status_id'] == 1)
                        <div class="review">
                            <p><strong>{{ $review['user']->name}}</strong> ({{ $review['star'] }})</p>
                            <p>{{ $review['review'] }}</p>
                        </div>
                        @endif
                    @endforeach
                        {{ $reviews->links('vendor.pagination.custom') }}
                @else
                    <p style="margin: 10px 10px 10px 0">На данный момент отзывов нет.</p>
                @endif
                @if(auth()->guard('web')->check())
                    @php
                    $bool = true;
                    foreach ($reviews->items() as $review)
                        {
                            if($review['user_id'] == auth()->id() && $review['product_id'] == $product->id)
                            {
                                $bool = false;
                            }
                        }
                    @endphp
                        <hr style="border: 1px solid gray">
                    @if($bool)
                    <form method="POST" id="store-review-form" action="{{route('product.store_review')}}" >
                        @csrf
                        <div class="review-div">
                            <h5>Написать отзыв о товаре:</h5>
                            <div>
                                <h6>Рейтинг:</h6>
                                <select style="margin-left: 20px;width: 60px; border: 1px solid gray;border-radius: 4px" name="rating-review">
                                    <option value="1" {{ request('rating-review') == '1' ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ request('rating-review') == '2' ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ request('rating-review') == '3' ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ request('rating-review') == '4' ? 'selected' : '' }}>4</option>
                                    <option value="5" {{ request('rating-review') == '5' ? 'selected' : '' }}>5</option>
                                </select>
                            </div>
                            <div>
                                <input hidden="hidden" name="product_id" value="{{$product->id}}">
                                <input hidden="hidden" name="user_id" value="{{auth()->guard('web')->id()}}">
                                <textarea placeholder="отзыв" class="textarea-review" id="review-textarea" name="review-textarea"></textarea>
                                <button type="submit" style="max-height: 50px; align-items: center; ">Отправить</button>
                            </div>
                        </div>
                    </form>
                @else
                    <p>Вы уже писали отзыв на данный товар</p>
                @endif
                <hr style="border: 1px solid gray">
                @endif
            </div>
            <div class="related-products">
                <h3>Рекомендации по сопутствующим товарам</h3>
                <div class="recommend-wrapper">
                    <button class="scroll-button prev-button">‹</button>
                    <div class="recommend-products" id="recommendProducts">
                        @if(!empty($bonds_products->items()))
                            @foreach($bonds_products->items() as $bond_product)
                                <div class="product-item">
                                    <div class="product-image">
                                        <a href="{{ route('product.index','id='. $bond_product['bond']->id) }}">
                                            <img src="{{ asset('images/' . $bond_product['bond']->main_image) }}" alt="{{ $bond_product['bond']->name }}">
                                        </a>
                                    </div>
                                    <div>
                                        <a href="{{ route('product.index', $bond_product['bond']->id) }}">{{ $bond_product['bond']->name }}</a>
                                        @if($bond_product['bond']->discount > 0)
                                            @php
                                                $originalPrice = $bond_product['bond']->price;
                                                $discountedPrice = $originalPrice - ($originalPrice * ($bond_product['bond']->discount / 100));
                                            @endphp
                                            <p class="discounted-price">{{ number_format($discountedPrice, 2, ',', ' ') }} р.</p>
                                            <p class="original-price">{{ number_format($originalPrice, 2, ',', ' ') }} р.</p>
                                        @else
                                            <p>{{ $bond_product['bond']->price }}р.</p>
                                        @endif
                                    </div>
                                    <form id="backet-form" method="POST" action="{{ route('backet.store') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $bond_product['bond']->id }}">
                                        <button class="submit-button" type="submit">Добавить</button>
                                    </form>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button class="scroll-button next-button">›</button>
                </div>
            </div>
@endsection
@section('scripts')
    @if(session('review'))
        <script>
            alert('{{session('review')}}')
        </script>
    @endif
    <script>
        function submitForm() {
            document.getElementById('paginate-form').submit();
        }
    </script>
@endsection
