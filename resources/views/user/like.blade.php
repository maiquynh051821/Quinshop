@extends('user.main')

@section('body')
    <section class="menu-product">
        <div class="menu-product-top">
            <h3>{{ $title }}</h3>
        </div>
        @if (count($products) != 0)
        <div id="loadProduct">
            @include('user.products.list')   
        </div>
         {{-- Phan trang --}}
     {{ $products->links() }}
        @else
            <h5 style="margin-bottom: 600px">Không có sản phẩm nào được thả tim</h5>
        @endif
    </section>
@endsection
