@extends('AdminDirectory.ComponentManagment.component-managment')
@section('component-content')
    <h4>Главная страница</h4>
    <div>
        <h6>Слайдер:</h6>
        <div class="recommend-wrapper">
            <button class="scroll-button prev-button" onclick="scrollProducts(-1)">‹</button>
            <div class="recommend-products" id="recommendProducts">
                @if(!empty($list_slider_products))
                    @foreach($list_slider_products as $slider_product)
                        <div class="product-item">
                            <div class="product-image">
                                <img src="{{ asset('images/' . $slider_product->main_image) }}" alt="{{ $slider_product->name }}">
                            </div>
                            <div>
                                <a href="{{ route('product.index', $slider_product->id) }}">{{ $slider_product->name }}</a>
                                @if($slider_product->discount > 0)
                                    @php
                                        $originalPrice = $slider_product->price;
                                        $discountedPrice = $originalPrice - ($originalPrice * ($slider_product->discount / 100));
                                    @endphp
                                    <p class="discounted-price">{{ number_format($discountedPrice, 2, ',', ' ') }} р.</p>
                                    <p class="original-price">{{ number_format($originalPrice, 2, ',', ' ') }} р.</p>
                                @else
                                    <p>{{ $slider_product->price }}р.</p>
                                @endif
                            </div>
                            <form id="slider-form" method="POST" action="{{ route('admin-panel.components.slider-destroy') }}">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $slider_product->id }}">
                                <button class="submit-button" type="submit">Удалить</button>
                            </form>
                        </div>
                    @endforeach
                @endif
            </div>
            <button class="scroll-button next-button" onclick="scrollProducts(1)">›</button>
        </div>
        <button id="addButton" style="margin-top: 20px;" onclick="
            document.getElementById('add-to-slider').hidden = false;
            document.getElementById('addButton').hidden=true;">Добавление товаров на слайдере</button>
        <div>
            <hr style="border: 1px solid gray">
            <form hidden="hidden" id="add-to-slider" name="add-to-slider" method="POST" action="{{ route('admin-panel.components.slider-add') }}">
                @csrf
                <div>
                    <select style="margin-top: 20px;width: 50%;border: 1px solid gray; border-radius: 5px;" name="product_id" id="product_id">
                        @foreach($products as $product)
                            @php
                                $bool = true;
                            foreach($list_slider_products as $in_slider_product)
                                if($product->id == $in_slider_product->id)
                                {
                                    $bool = false;
                                }
                            @endphp
                            @if($bool)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <div style="margin-top: 20px">
                        <button style="margin-left: 0px;background: gray;" class="profile-button" type="button" onclick="canselButton()">Отмена</button>
                        <button class="profile-button" type="submit">Добавить</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="recommend-wrapper">
            <button class="scroll-button prev-button" onclick="scrollProducts(-1)">‹</button>
            <div class="recommend-products" id="recommendProducts">
                @if(!empty($list_recommend_products))
                    @foreach($list_recommend_products as $recommend_product)
                        <div class="product-item">
                            <div class="product-image">
                                <img src="{{ asset('images/' . $recommend_product->main_image) }}" alt="{{ $recommend_product->name }}">
                            </div>
                            <div>
                                <a href="{{ route('product.index', $recommend_product->id) }}">{{ $recommend_product->name }}</a>
                                @if($recommend_product->discount > 0)
                                    @php
                                        $originalPrice = $recommend_product->price;
                                        $discountedPrice = $originalPrice - ($originalPrice * ($recommend_product->discount / 100));
                                    @endphp
                                    <p class="discounted-price">{{ number_format($discountedPrice, 2, ',', ' ') }} р.</p>
                                    <p class="original-price">{{ number_format($originalPrice, 2, ',', ' ') }} р.</p>
                                @else
                                    <p>{{ $recommend_product->price }}р.</p>
                                @endif
                            </div>
                            <form id="slider-form" method="POST" action="{{ route('admin-panel.components.recommend-destroy') }}">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $recommend_product->id }}">
                                <button class="submit-button" type="submit">Удалить</button>
                            </form>
                        </div>
                    @endforeach
                @endif
            </div>
            <button class="scroll-button next-button" onclick="scrollProducts(1)">›</button>
        </div>
        <button style="margin-top: 20px;" id="addRecommendButton" onclick="
            document.getElementById('add-to-recommend').hidden = false;
            document.getElementById('addRecommendButton').hidden=true;" >Добавление рекомендованных товаров</button>
        <div>
            <form hidden="hidden" id="add-to-recommend" name="add-to-recommend" method="POST" action="{{ route('admin-panel.components.recommend-add') }}">
                @csrf
                <div>
                    <select style="margin-top: 20px;width: 50%;border: 1px solid gray; border-radius: 5px;" name="product_id" id="product_id">
                        @foreach($products as $product)
                            @php
                                $bool = true;
                            foreach($list_recommend_products as $in_recommend_product)
                                if($product->id == $in_recommend_product->id)
                                {
                                    $bool = false;
                                }
                            @endphp
                            @if($bool)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <div style="margin-top: 20px">
                        <button style="margin-left: 0px;background: gray;" class="profile-button" type="button" onclick="canselRecommendButton()">Отмена</button>
                        <button class="profile-button" type="submit">Добавить</button>
                    </div>
                </div>
            </form>
        </div>
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
