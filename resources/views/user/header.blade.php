<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src='https://kit.fontawesome.com/1147679ae7.js' crossorigin='anonymous'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/template/css/main.css">
    <link rel="stylesheet" href="/template/css/style.css">
    <link rel="stylesheet" href="/template/bootstrap-5.3.3-dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/template/bootstrap-5.3.3-dist/js/bootstrap.js">
    <link rel="shortcut icon" type="image/png" href="/template/images/icons/logo-quinshop.png"/> 
    <title>{{$title}}</title>
    
</head>
@php
  $menusHtml = \App\Helpers\Helper::menus($menus);
@endphp
<body>
    <section class="fixed-header">
        <div class="logo">
            <b>QUIN-SHOP</b>
        </div>
        <div class="menu">
            <li><a href="/">Trang chủ</a></li>
            {!! $menusHtml !!}
        </div>
        <div class="others">
            <input placeholder="Tìm kiếm" type="text">
            <button><i class="fas fa-search"></i></button>
        </div>
        <div class="favorite">
            <li><a href="/likes" class="fas fa-heart">
                @if ($likeCount != 0)
                <span style="border-radius:50px" class="badge">{{ $likeCount }}</span>
            @endif
            </a></li>
        </div>
        <div class="shopping">
            <li><a href="/carts" class="fa fa-shopping-bag">
                @if ($cartCount != 0)
                <span style="border-radius:50px" class="badge">{{ $cartCount }}</span>

                @endif
            </a></li>
        </div>
        <div class="login">
            @guest
                <li><a href="/login"><button class="btn btn-success">Đăng nhập</button></a></li>
            @else
                <div class="user-info">
                    <i class="fas fa-user"></i> <span>{{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}" 
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <button id="logout" class="btn btn-danger btn-logout">Đăng xuất</button>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            @endguest
        </div>
    </section>
    
    @yield('user.header')
</body>
</html>
