<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://kit.fontawesome.com/1147679ae7.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="/template/css/main.css">
    <link rel="stylesheet" href="/template/css/style.css">
    <link rel="stylesheet" href="/template/bootstrap-5.3.3-dist/css/adminlte.min.css">
    <title>Qinnn-Shop</title>
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
			<li><a href="">Trang chủ</a></li>

			{!! $menusHtml !!}
			
        </div>
        <div class="others">
            <input placeholder="Tìm kiếm" type="text" >
				<button><i class="fas fa-search"></i></button>
        </div>
		<div class="shopping">
			<li><a href="" class="fa fa-shopping-bag"></a></li>
		</div>
		<div class="login">
			<li><a href=""><button class="btn btn-success">Đăng nhập</button></a></li>
		</div>
    </section>
    @yield('user.header')