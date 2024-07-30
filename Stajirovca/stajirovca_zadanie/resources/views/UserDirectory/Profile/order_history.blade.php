@extends('UserDirectory.Profile.profile')
@section('profile-content')
    <h4 style="margin-top: 20px; margin-left: 20px">История заказов</h4>
    <div style="margin-top: 20px; margin-left: 20px; max-height: 500px; overflow-y: scroll;">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Номер заказа</th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Действие</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->status->name }}</td>
                    <td><button class="btn btn-primary" onclick="toggleOrderDetails({{ $order->id }})">Просмотр</button></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @foreach($orders as $order)
        <div id="order-details-{{ $order->id }}" style="display: none; margin-top: 20px; margin-left: 20px;">
            <h4>Заказ #{{ $order->id }}</h4>
            <div style="display: flex;">
                <div style="margin-right: 20px">
                    <p><strong>Дата:</strong> {{ $order->created_at }}</p>
                    <p><strong>Сумма:</strong> {{ $order->total }}р.</p>
                    <p><strong>Статус:</strong> {{ $order->status->name }}</p>
                    <p><strong>Тип оплаты:</strong> {{ $order->paymentType->name }}</p>
                    <p><strong>Тип получения:</strong> {{ $order->receivingType->name }}</p>
                </div>
                <div>
                    <p><strong>ФИО:</strong> {{ $order->FIO }}</p>
                    <p><strong>Адрес:</strong> {{ $order->address }}</p>
                    <p><strong>Телефон:</strong> {{ $order->phone }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Комментарий:</strong> {{ $order->comment }}</p>
                </div>
            </div>
            <h5>Товары</h5>
            <ul>
                @foreach($order->products as $product)
                    <li>{{ $product['name'] }} - {{ $product['quantity'] }} шт. - {{ $product['price'] }} руб.</li>
                @endforeach
            </ul>
            <button class="btn btn-secondary" onclick="toggleOrderDetails({{ $order->id }})">Скрыть</button>
        </div>
    @endforeach
@endsection
@section('scripts')
    @parent
    <script>
        let i = 0;
        function toggleOrderDetails(orderId) {
            const orderDetails = document.getElementById(`order-details-${orderId}`);
            if (orderDetails.style.display === 'none') {
                let str = 'order-details-';
                str +=i;
                const detail = document.getElementById(str);
                if (detail != null)
                    detail.style.display = 'none';
                orderDetails.style.display = 'block';
                i = orderId;
            } else {
                orderDetails.style.display = 'none';
            }
        }
    </script>
@endsection
