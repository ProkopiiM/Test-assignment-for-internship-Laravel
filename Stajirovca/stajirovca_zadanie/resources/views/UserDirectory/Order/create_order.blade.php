@extends('layout')
@section('title')
    Создание заказа
@endsection
@section('main-content')
    <h1>Создание заказа</h1>
    <div>
        <h2>Товары в корзине</h2>
        @if(!empty($backet_list))
            <ul>
                @php
                    $i = 1;
                    $sum=0;
                    $sum_all = 0;
                @endphp
                @foreach($backet_list as $item)
                    @php
                        if ($item['discount'] > 0)
                                {
                                    $sum_all += $item['quantity'] * $item['price'];
                                    $sum += $item['quantity'] * ($item['price'] - ($item['price'] * ($item['discount'] / 100)));
                                }
                            else
                                {
                                    $sum += $item['quantity'] * $item['price'];
                                    $sum_all += $sum;
                                }
                    @endphp
                    <li>Товар:{{ $item['name'] }} - Количество {{ $item['quantity'] }} шт. - Цена:{{ $item['price'] }} р./шт.</li>
                @endforeach
            </ul>
            @if($sum != 0)
                <div style="display: flex">
                    <p style="margin-right: 5px">Итоговая сумма: </p>
                    <p style="color: green"> {{$sum}} р.</p>
                    <p style="font-size: 12px; color: gray"> {{$sum_all}}р.</p>
                </div>
            @else
                <p style="font-size: 12px; color: black"> {{$sum_all}}</p>
            @endif
        @else
            <p>Корзина пуста.</p>
        @endif
    </div>
    <div>
        @if(!empty($backet_list))
            <h2>Информация о заказе</h2>
            <form id="create-order-form" method="POST" action="{{route('order.store')}}">
                @csrf
                <p class="required-info">* Поля, помеченные звездочкой, являются обязательными для заполнения.</p>
                @if($sum != 0)
                    <input hidden="hidden" name="total" value="{{$sum}}">
                @else
                    <input hidden="hidden" name="total" value="{{$sum_all}}">
                @endif
                <div class="order-div">
                    <div>
                        <h6>* Выбор способа оплаты</h6>
                        <select name="payment">
                            @foreach($payments as $p)
                                <option value="{{$p->id}}" {{ request('payment') == $p->id ? 'selected' : '' }}>{{$p->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <h6>* Выбор способа доставки</h6>
                        <select id="receiving" name="receiving" onchange="hiddenBlock()">
                            <option></option>
                            @foreach($receivings as $receiving)
                                <option value="{{$receiving->id}}" {{ request('$receiving') == $receiving->id ? 'selected' : '' }}>{{$receiving->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="delivery-block" hidden="hidden">
                        <h6>* Адрес доставки</h6>
                        <input placeholder="адрес" type="text" name="address" id="address" {{old('address')}}>
                    </div>
                </div>
                <div class="order-div">
                    <div style="margin-top: 20px">
                        <h6>Информация о покупателе</h6>
                        <div>
                            *Почта:
                            <input minlength="8" placeholder="name@mail.ru" type="email" name="email" id="email" value="{{$user->email ?? old('email')}}">
                        </div>
                        <div>
                            *ФИО:
                            <input minlength="8" placeholder="name" type="text" name="name" id="name" value="{{$user->name ?? old('name')}}">
                        </div>
                        <div>
                            *Номер телефона:
                            <input minlength="16" placeholder="+7(999)999-99-99" type="tel" name="phone" id="phone" value="{{$user->phone ?? old('phone')}}">
                        </div>
                    </div>
                </div>
                <div style="display: flex">
                    <div style="flex-grow: 1;"></div>
                    <button class="profile-button" type="submit">Подтвердить заказ</button>
                </div>
            </form>
        @endif
    </div>
@endsection
@section('scripts')
    <script>
        @if(session('error'))
        alert('{{ session('error') }}');
        @endif
    </script>
    <script>
        function hiddenBlock() {
            var select = document.getElementById('receiving');
            var deliveryBlock = document.getElementById('delivery-block');

            if (select.value == '1') {
                deliveryBlock.hidden = false;
            } else {
                deliveryBlock.hidden = true;
            }
        }
        document.addEventListener('DOMContentLoaded', (event) => {
            toggleDeliveryBlock();
        });
        const phoneInput = document.getElementById('phone');

        phoneInput.addEventListener('input', function(event) {
            const input = event.target.value.replace(/\D/g, '').substring(0, 11);
            const phoneFormat = '+7 (' + input.substring(1, 4) + ') ' + input.substring(4, 7) + '-' + input.substring(7, 9) + '-' + input.substring(9, 11);
            event.target.value = phoneFormat;
        });
    </script>
@endsection
