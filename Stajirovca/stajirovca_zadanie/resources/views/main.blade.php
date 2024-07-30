@extends('layout')
@section('title')
Главная страница
@endsection
@section('main-content')
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="5000">
        <ol class="carousel-indicators">
            @if(!empty($list_main_product))
                @php
                $i =0;
                @endphp
                @foreach($list_main_product as $product)
                    @if($list_main_product[0] == $product)
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        @php
                        $i++;
                        @endphp
                    @else
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}"></li>
                        @php
                            $i++;
                        @endphp
                    @endif
                @endforeach
            @endif
        </ol>
        <div class="carousel-inner">
            @if(!empty($list_main_product))
                @php
                    $i =0;
                @endphp
                @foreach($list_main_product as $product)
                        @if($list_main_product[0] == $product)
                        <div style="height: 500px; width: 1200px" class="carousel-item active">
                            <a href="/product?id={{$product->id}}">
                                <img style="height: 500px; width: 1200px" src="{{asset("images/".$product->main_image)}}" class="d-block w-50 mx-auto" alt="{{$product->name}}">
                            </a>
                            <div class="carousel-caption d-none d-md-block">
                                <h5 style="color: black">{{$product->name}}</h5>
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
                    @else
                        <div style="height: 500px; width: 1200px" class="carousel-item">
                            <a href="/product?id={{$product->id}}">
                                <img style="max-height: 500px; max-width: 1200px" src="{{asset("images/".$product->main_image)}}" class="d-block w-50 mx-auto" alt="{{$product->name}}">
                            </a>
                            <div class="carousel-caption d-none d-md-block">
                                <h5 style="color: black">{{$product->name}}</h5>
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
                        @endif
                @endforeach
            @endif
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div>
        <h4>Рекомендуемые</h4>
        <div class="recommend-wrapper">
            <button class="scroll-button prev-button" onclick="scrollProducts(-1)">‹</button>
            <div class="recommend-products" id="recommendProducts">
                @if(!empty($list_recommend_product))
                    @foreach($list_recommend_product as $recommend_product)
                        <div class="product-item">
                            <div class="product-image">
                                <a href="{{ route('product.index','id='. $recommend_product->id) }}">
                                    <img src="{{ asset('images/' . $recommend_product->main_image) }}" alt="{{ $recommend_product->name }}">
                                </a>
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
                            <form id="backet-form" method="POST" action="{{ route('backet.store') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $recommend_product->id }}">
                                <button class="submit-button" type="submit">Добавить</button>
                            </form>
                        </div>
                    @endforeach
                @endif
            </div>
            <button class="scroll-button next-button" onclick="scrollProducts(1)">›</button>
        </div>
    </div>
@endsection
@section('scripts')
    @if(!empty($status))
        <script>
            alert('Смена пароля прошла успешно');
        </script>
    @endif
    @if(session('registration')))
        <script>
            alert('{{session('registration')}}');
        </script>
    @endif
    <script>
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
