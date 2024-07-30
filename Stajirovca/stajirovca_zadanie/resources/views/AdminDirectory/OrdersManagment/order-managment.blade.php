@extends('AdminDirectory.layout_admin')
@section('title')
    Управление заказами
@endsection
@section('main-content')
    <div class="products-managment">
        <form id="searchForm" method="GET" action="{{ route('admin-panel.orders.index') }}">
            <div style="display: flex">
                <div>
                    Тип оплаты:
                    <select name="payment_type" onchange="submitForm()">
                        <option value="all" {{request('status') == 'all' ? 'selected' : ''}}>Любой</option>
                        @foreach($payment_types as $payment)
                            <option value="{{ $payment->id }}" {{ request('payment_type') == $payment->id ? 'selected' : '' }}>
                                {{ $payment->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    Сортировка:
                    <select name="sort" onchange="submitForm()">
                        <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>По умолчанию</option>
                        <option value="status_asc" {{ request('sort') == 'status_asc' ? 'selected' : '' }}>Статус (1-6)</option>
                        <option value="status_desc" {{ request('sort') == 'status_desc' ? 'selected' : '' }}>Статус (6-1)</option>
                        <option value="total_asc" {{ request('sort') == 'total_asc' ? 'selected' : '' }}>Цена (низкая > высокая)</option>
                        <option value="total_desc" {{ request('sort') == 'total_desc' ? 'selected' : '' }}>Цена (высокая > низкая)</option>
                        <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Новизна (старые > новые)</option>
                        <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Новизна (новые > старые)</option>
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
                    Тип получения:
                    <select name="receiving_type" onchange="submitForm()">
                        <option value="all" {{request('status') == 'all' ? 'selected' : ''}}>Любой</option>
                        @foreach($receiving_types as $receiving_type)
                            <option value="{{ $receiving_type->id }}" {{ request('receiving_type') == $receiving_type->id ? 'selected' : '' }}>
                                {{ $receiving_type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    Статус:
                    <select name="status" onchange="submitForm()">
                        <option value="all" {{request('status') == 'all' ? 'selected' : ''}}>Любой</option>
                        @foreach($statuses as $status)
                            <option value="{{$status->id}}" {{ request('status') == $status->id ? 'selected' : '' }}>{{$status->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    Цена:
                    <div style="display: flex">
                        <input onchange="submitForm()" style="padding: 5px" type="text" onkeypress="return /[0-9]/i.test(event.key)"  name="min-total" min="0" placeholder="от" value="{{request('min-total')}}">
                        <input onchange="submitForm()" style="padding: 5px" type="text" onkeypress="return /[0-9]/i.test(event.key)"  name="max-total" min="0" placeholder="до" value="{{request('max-total')}}">
                    </div>
                </div>
            </div>
        </form>
        <hr style="margin-top: 25px; margin-bottom: 25px">
        @if(!empty($orders))
            <h4>Результаты поиска</h4>
            <div id="search-results" class="grid-view">
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
                                <p><strong>Тип оплаты:</strong> {{ $order->paymentType->name }}</p>
                                <p><strong>Тип получения:</strong> {{ $order->receivingType->name }}</p>
                                <p><strong>Комментарий:</strong> {{ $order->comment }}</p>
                            </div>
                            <div>
                                <p><strong>ФИО:</strong> {{ $order->FIO }}</p>
                                <p><strong>Адрес:</strong> {{ $order->address }}</p>
                                <p><strong>Телефон:</strong> {{ $order->phone }}</p>
                                <p><strong>Email:</strong> {{ $order->email }}</p>
                                <p><strong>Статус:</strong> {{ $order->status->name }}</p>
                            </div>
                               <div style="margin-left: 10px">
                                   <form id="redact-status" method="POST" action="{{route('admin-panel.orders.update')}}">
                                       @method('PUT')
                                       @csrf
                                       <input hidden="hidden" name="id" value="{{$order->id}}">
                                       <div>
                                           <h6>Обновление статуса</h6>
                                           <select name="status_id">
                                               @foreach($statuses as $status)
                                                   @if($status->id >= $order->status_id)
                                                       <option value="{{$status->id}}" {{ request('status') == $status->id ? 'selected' : '' }}>{{$status->name}}</option>
                                                   @endif
                                               @endforeach
                                           </select>
                                       </div>
                                       <div>
                                           <h6>Добавить комментарий</h6>
                                           <textarea id="comment" name="comment"></textarea>
                                       </div>
                                       <button class="profile-button" style="margin-left: 10px" type="submit">Изменить</button>
                                   </form>
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
            </div>
        @else
            <p>Результатов не найдено.</p>
        @endif
        {{ $orders->links() }}
    </div>
@endsection
@section('scripts')
    <script>
        function createNewProduct()
        {
            window.location.href = '{{'/admin-panel/product'}}';
        }
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
        function submitForm() {
            document.getElementById('searchForm').submit();
        }
    </script>
@endsection
