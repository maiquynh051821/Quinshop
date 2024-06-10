@extends('user.main')

@section('body')
    <section class="menu-product">
        <div class="menu-product-top">
            <h3>{{ $title }}</h3>
        </div>
        <div class="filter">
                <label for="sort">Sắp xếp:</label>
                <select id="sort" onchange="sortProducts(this.value)">
                    <option value=""></option>
                    <option value="{{ request()->url() }}">Mới nhất</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort_price' => 'asc']) }}" {{ request('sort_price') == 'asc' ? 'selected' : '' }}>Giá tăng dần</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort_price' => 'desc']) }}" {{ request('sort_price') == 'desc' ? 'selected' : '' }}>Giá giảm dần</option>
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


