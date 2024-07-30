@extends('layout')
@section('title')
    Корзина
@endsection
@section('main-content')
    <div>
        <h3>Корзина</h3>
        @if(!empty($backet_list))
            <div>
                @php
                    $i = 1;
                    $sum=0;
                    $sum_all = 0;
                @endphp
                @foreach($backet_list as $backet)
                   <div class="backet-div">
                       @php
                           if ($backet['discount'] > 0)
                                   {
                                       $sum_all += $backet['quantity'] * $backet['price'];
                                       $sum += $backet['quantity'] * ($backet['price'] - ($backet['price'] * ($backet['discount'] / 100)));
                                   }
                               else
                                   {
                                       $sum += $backet['quantity'] * $backet['price'];
                                       $sum_all += $sum;
                                   }
                       @endphp
                       <div>
                           <h6>{{$i}}</h6>
                       </div>
                       <div>
                           <a href="{{ route('product.index','id='. $backet['id']) }}">
                               <img src="{{ asset('images/' . $backet['image']) }}" alt="{{ $backet['name'] }}">
                           </a>
                       </div>
                       <div>
                           <h6> {{$backet['name']}}</h6>
                       </div>
                       <div style="flex-grow: 1;"></div>
                       <div>
                           Количество:
                           <div style="display: flex">
                               <form id="edit-count-product-plus" method="POST" action="{{ route('backet.edit') }}" style="margin-right: 10px;">
                                   @csrf
                                   <input type="hidden" value="{{ $backet['id'] }}" name="product_id">
                                   <input type="hidden" value="plus" name="action">
                                   <button type="submit" class="profile-button" name="add_button">
                                       <iconify-icon icon="ic:baseline-plus"></iconify-icon>
                                   </button>
                               </form>
                               <p>{{ $backet['quantity'] }}</p>
                               <form id="edit-count-product-minus" method="POST" action="{{ route('backet.edit') }}">
                                   @csrf
                                   <input type="hidden" value="{{ $backet['id'] }}" name="product_id">
                                   <input type="hidden" value="minus" name="action">
                                   <button type="submit" class="profile-button" name="minus_button">
                                       <iconify-icon icon="ic:baseline-minus"></iconify-icon>
                                   </button>
                               </form>
                           </div>
                       </div>
                       <div style="margin-left: 10px; padding-top: 25px">
                           <form id="del-product" method="POST" action="{{ route('backet.edit') }}">
                               @csrf
                               <input type="hidden" value="{{ $backet['id'] }}" name="product_id">
                               <input type="hidden" value="del" name="action">
                               <button type="submit" class="profile-button" name="del_button">
                                   Удалить
                               </button>
                           </form>
                       </div>
                   </div>
                @endforeach
            </div>
            <div style="display: flex;">
                <div style="flex-grow: 1;"></div>
                @if($sum != 0)
                    <div style="display: flex">
                        <p style="margin-right: 5px">Итоговая сумма: </p>
                        <p style="color: green"> {{$sum}} р.</p>
                        <p style="font-size: 12px; color: gray"> {{$sum_all}}р.</p>
                    </div>
                @else
                    <p style="font-size: 12px; color: black"> {{$sum_all}}</p>
                @endif
            </div>
            <div
            style="display: flex">
                <div style="flex-grow: 1;"></div>
                <div>
                    <form name="clear-backet" method="POST" action="/backet/clear">
                        @csrf
                        <button style="background: gray" type="submit" class="profile-button">Очистить корзину</button>
                    </form>
                </div>
                <div>
                    <form id="create-order" method="GET" action="{{ route('order.index') }}">
                        @csrf
                        <button class="profile-button" type="submit">Создать заказ</button>
                    </form>
                </div>
            </div>
        @else
            <p>Товары в корзине отсутствуют.</p>
        @endif
    </div>
@endsection
