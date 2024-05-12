@extends('user.main')

@section('body')
    <section class="product">
        <div class="product-top">
            <h3>{{ $title }}</h3>
        </div>
        <div class="filter">
                <label for="sort">Sắp xếp:</label>
                <select id="sort" onchange="sortProducts(this.value)">
                    <option value="default">Mặc định</option>
                    <option value="price_asc">Giá tăng dần</option>
                    <option value="price_desc">Giá giảm dần</option>
                </select>
            </div>
        <div id="loadProduct">
            @include('user.products.list')   
        </div>
         {{-- Phan trang --}}
     {{ $products->links() }}
    </section>
    
@endsection
