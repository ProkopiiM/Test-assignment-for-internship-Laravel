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
        <a href="/" class="logo">
            <img src="{{asset("images/logo.png")}}" style="max-height: 100px; max-width: 50px" alt="CompanyLogo">
        </a>
        <div style="flex-grow: 1;"></div>
        <button style="" class="profile-button" onclick="redirect()">
            <iconify-icon icon="mdi:user"></iconify-icon>
        </button>
    </div>
</header>
<div class="container" style="min-height: 70vh">
        @yield("main-container")
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
@yield('scripts')
<script>
    function redirect(){
        window.location.href = "{{ route('profile.index') }}";
    }
</script>
</body>
</html>
