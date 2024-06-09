@extends('user.main')

@section('body')
    <section class="menu-product">
        <div class="menu-product-top">
            <h3>{{ $title }}</h3>
        </div>
        
        <div id="loadProduct">
            @include('user.products.list')   
        </div>
         {{-- Phan trang --}}
     {{ $products->links() }}
    </section>
@endsection
