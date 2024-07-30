<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield("meta")
    @vite('resources/css/app.css')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>@yield("title")</title>
</head>
<body>
    <header class="header">
        <div style="display: flex">
            <a style="margin-right: 5%" href="/" class="logo">
                <img src="{{asset("images/logo.png")}}" style="max-height: 100px; max-width: 50px" alt="CompanyLogo">
            </a>
            <input type="text" id="search" name="search" class="search-input" placeholder="Поиск" value="{{ request('search') }}">
            <button class="profile-button" style="background: gray; margin-left: 5px" onclick="searchProduct()">
                <iconify-icon icon="material-symbols:search"></iconify-icon>
            </button>
            <button class="profile-button" onclick="profileRedirect()">
                <iconify-icon icon="mdi:user"></iconify-icon></button>
            <button class="profile-button" onclick="backetRedirect()">
                <iconify-icon icon="ph:basket"></iconify-icon>
            </button>
            <div style="display: flex">
                <h6>Товаров:</h6>
                @if(auth()->guard('web')->check())
                    @php
                        $backets = \App\Models\Backet::where('user_id', auth()->guard('web')->id())->first();
                        $itemsCount = 0;
                        if ($backets && $backets->products) {
                            $products = json_decode($backets->products, true);
                            if (isset($products) && is_array($products)) {
                                foreach ($products as $item) {
                                     $itemsCount += $item['quantity'];
                                }
                            }
                        }
                    @endphp
                    {{ $itemsCount }}
                @else
                    @php
                        $itemsCount = 0;
                        if (session()->has('backet')) {
                            foreach (session()->get('backet')['items'] as $item) {
                                $itemsCount += $item['quantity'];
                            }
                        }
                    @endphp
                    <p style="padding-left:3px ">{{ $itemsCount }}</p>
                @endif
            </div>
        </div>
        <div style="display: flex; background: lightblue; border-radius: 10px;margin-top: 10px">
            <div class="dropdown-row">
                @if(!empty($categories))
                    @foreach($categories as $category)
                        <a href="/category?category_id={{$category->id}}" class="dropdown-item">
                            {{$category->name}}
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </header>
    <div class="container" style="min-height: 100vh">
        <div id="main-content">
            @yield('main-content')
        </div>
    </div>
    <footer class="alter-footer">
        <div class="footer">
            <div class="footer-container">
                <div class="footer-column">
                    <h3>Информация</h3>
                    <ul>
                       @if(!empty($cards))
                            @foreach($cards as $card)
                                <li><a href="/information?id={{$card->id}}">{{$card->title}}</a></li>
                            @endforeach
                       @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="alter-footer">
            <div style="width: 80%; margin-left: 10%">
                <hr style="border: 1px solid gray">
                <div style="padding: 0 20px; margin-top: 10px">
                    <h5>Интернет магазин .... 2024</h5>
                </div>
            </div>
        </div>
    </footer>
    <script>
        function profileRedirect()
        {
            window.location.href = "{{ route('profile.index') }}";
        }
        function backetRedirect()
        {
            window.location.href = "{{ route('backet.index') }}";
        }
        function searchProduct()
        {
            var search = document.getElementById("search").value;
            if (search.length >= 3)
                window.location.href = "{{ route('search.index') }}?search="+search;
        }
    </script>
    @if(!empty($error))
        <script>
            alert({{$error}})
        </script>
    @endif
    @yield('scripts')
</body>
</html>
