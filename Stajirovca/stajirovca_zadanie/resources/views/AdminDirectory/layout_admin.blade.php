<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @yield("meta")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <title>@yield("title")</title>
</head>
<body>
<header class="header">
    <div style="display: flex;margin-bottom: 50px">
        <a style="margin-right: 5%" href="/admin-panel" class="logo">
            <img src="{{asset("images/logo.png")}}" style="max-height: 100px; max-width: 50px" alt="CompanyLogo">
        </a>
    </div>
    @if(auth()->guard('admin')->check())
        <div style="display: flex; background: lightblue; border-radius: 10px;margin-top: 10px">
            <div class="dropdown-row">
                <a href="/admin-panel/products" class="dropdown-item">
                    Управление продуктами
                </a>
                <a href="/admin-panel/orders" class="dropdown-item">
                    Управление заказами
                </a>
                @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->role_id == 1)
                    <a href="/admin-panel/users" class="dropdown-item">
                        Управление пользователя
                    </a>
                    <a href="/admin-panel/components" class="dropdown-item">
                        Управление компонентами
                    </a>
                @endif
            </div>
        </div>
    @endif
</header>
<div class="container" style="min-height: 100vh;padding-bottom: 50px">
    <div id="main-content">
        @yield('main-content')
    </div>
</div>
<footer class="alter-footer" style="min-height: 100px">

</footer>
@if(!empty($error))
    <script>
        alert({{$error}})
    </script>
@endif
@yield('scripts')
</body>
</html>
