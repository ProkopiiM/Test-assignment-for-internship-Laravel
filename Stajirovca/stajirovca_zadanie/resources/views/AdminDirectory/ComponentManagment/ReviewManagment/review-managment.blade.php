@extends('AdminDirectory.layout_admin')
@section('title')
    Управление заказами
@endsection
@section('main-content')
    <div class="products-managment">
        <form id="searchForm" method="GET" action="{{ route('admin-panel.reviews.review.index') }}">
            <div style="display: flex">
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
                    Сортировка:
                    <select name="sort" onchange="submitForm()">
                        <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>По умолчанию</option>
                        <option value="status_asc" {{ request('sort') == 'status_asc' ? 'selected' : '' }}>Статус (1-6)</option>
                        <option value="status_desc" {{ request('sort') == 'status_desc' ? 'selected' : '' }}>Статус (6-1)</option>
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
        </form>
        <hr style="margin-top: 25px; margin-bottom: 25px">
        @if(!empty($reviews))
            <h4>Результаты поиска</h4>
            <div id="search-results" class="grid-view">
                <div style="margin-top: 20px; margin-left: 20px; max-height: 500px; overflow-y: scroll;">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Номер отзыва</th>
                            <th>Дата</th>
                            <th>Отзыв</th>
                            <th>Товар</th>
                            <th>Статус</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reviews as $review)
                            <tr>
                                <td>{{ $review->id }}</td>
                                <td>{{ $review->created_at }}</td>
                                <td>{{ $review->review }}</td>
                                <td>{{ $review->product->name }}</td>
                                <td>
                                    <form id="review-form-{{$review->id}}" method="GET" action="{{route('admin-panel.reviews.review.update',$review->id)}}">
                                        @csrf
                                        <select id="status" name="status" onchange="changeReview({{$review->id}})">
                                            <option value="1" {{ $review->status_id == '1' ? 'selected' : '' }}>Обработано</option>
                                            <option value="2" {{ $review->status_id == '2' ? 'selected' : '' }}>Необработано</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <p>Результатов не найдено.</p>
                @endif
                {{ $reviews->links() }}
            </div>
    </div>
@endsection
@section('scripts')
    <script>
        function changeReview(reviewId)
        {
            document.getElementById('review-form-'+reviewId).submit()
        }

        function submitForm() {
            document.getElementById('searchForm').submit();
        }
    </script>
@endsection
