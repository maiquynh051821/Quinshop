@extends('user.main')

@section('body')
<section class="slider">
    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($sliders as $key => $slider)
            <div class="carousel-item{{ $key == 0 ? ' active' : '' }}" data-bs-interval="10000">
                 {{-- Tu dong chuyen slider sau 10s --}}
                <img src="{{ $slider->thumb }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>{{$slider->name }}</h5>
                    <a href="{{$slider->url}}"><button class="btn btn-sm">Shop now</button></a>
                </div>
            </div>
            @endforeach
        </div>
    
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    </section>
    <section class="category">
        <h2>Tổng quan sản phẩm</h2>
        <h6>Tất cả sản phẩm</h6>
        <div id="loadProduct">
            @include('user.products.list')
        </div>

        <div class="button-loadmore" id="button-loadMore">
            <input type="hidden" value="1" id="page">
            <a onclick="loadMore()"><button>XEM THÊM</button></a>
        </div>
    </section>
@endsection