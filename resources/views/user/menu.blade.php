@extends('user.main')

@section('body')
    <section class="product">
        <div class="product-top">
            <h3>{{ $title }}</h3>
        </div>
        <div class="filter">
                <label for="sort">Sắp xếp:</label>
                <select id="sort" onchange="sortProducts(this.value)">
                    <option value=""></option>
                    <option value="{{request()->url()}}">Mặc định</option>
                    <option value="{{request()->fullUrlWithQuery(['price_sale' => 'asc'])}}">Giá tăng dần</option>
                    <option value="{{request()->fullUrlWithQuery(['price_sale' => 'desc'])}}">Giá giảm dần</option>
                </select>
            </div>
        <div id="loadProduct">
            @include('user.products.list')   
        </div>
         {{-- Phan trang --}}
     {{ $products->links() }}
    </section>
    <script>
        function sortProducts(value) {
            window.location.href = value; // Chuyển hướng trang đến link được chọn
        }
    </script>
@endsection
