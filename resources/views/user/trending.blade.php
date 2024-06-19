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
            <div class="category-content">
                @foreach ($products as $key => $product)
                    <div class="category-content-item">
                        <a href="/san-pham/{{ $product->id }}-{{ \Str::slug($product->name, '-') }}.html">
                            <div class="image-container">
                                <?php
                                $thumbs = json_decode($product->thumb);
                                $firstThumb = $thumbs[0] ?? null;    
                                ?>
                                <img class="anhsp" src="{{ asset($firstThumb) }}" alt="">
                                @if ($product->price_sale !== null)
                                    <div class="sale-badge">
                                        {{ round((($product->price - $product->price_sale) / $product->price) * 100) }}%
                                    </div>
                                @endif
                            </div>
                        </a>
                        <div class="product-details">
                            <a href="/san-pham/{{ $product->id }}-{{ \Str::slug($product->name, '-') }}.html">
                                <h1>{{ $product->name }}</h1>
                            </a>
            
            
                            <div class="favorite-icon">
                                @if (Auth::check()) <!-- Kiểm tra xem có người dùng đã đăng nhập hay không -->
                                    <form method="post" action="{{ route('products.like', $product->id) }}">
                                        @csrf
                                        <button style="border: none; background-color: transparent" type="submit">
                                            <i class="fas fa-heart {{ Auth::user()->favoriteProducts->contains($product->id) ? 'liked' : '' }}"></i>
                                        </button>
                                    </form>
                                @else
                                <button style="border: none;background-color:transparent" type="button" class="login-prompt">
                                    <i class="fas fa-heart"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                        <div class="price-product">
                            @if ($product->price_sale !== null)
                                <ins><span>{!! \App\Helpers\Helper::price($product->price_sale) !!}<sup>đ</sup></span></ins>
                                <del><span>{!! \App\Helpers\Helper::price($product->price) !!}<sup>đ</sup></span></del>
                            @elseif($product->price_sale == null && $product->price == null)
                                <span>{!! \App\Helpers\Helper::price($product->price) !!}</span>
                            @else
                                <span>{!! \App\Helpers\Helper::price($product->price) !!}<sup>đ</sup></span>
                            @endif
                        </div>
            
                    </div>
                @endforeach
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const loginPrompts = document.querySelectorAll('.login-prompt');
                    loginPrompts.forEach(button => {
                        button.addEventListener('click', function () {
                            alert('Vui lòng đăng nhập để thả tim sản phẩm.');
                        });
                    });
                    const favoriteForms = document.querySelectorAll('.favorite-icon form');
                    favoriteForms.forEach(form => {
                        form.addEventListener('submit', function(event) {
                            event.preventDefault();
                            const heartIcon = this.querySelector('i');
                            const isLiked = heartIcon.classList.contains('liked');
                            const productId = this.action.split('/').pop();
                            const url = isLiked ? `/products/${productId}/unlike` :
                                `/products/${productId}/like`;
            
                            fetch(url, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute('content')
                                    },
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.liked) {
                                        heartIcon.classList.add('liked');
                                    } else {
                                        heartIcon.classList.remove('liked');
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        });
                    });
                });
                .then(data => {
                console.log(data);  // Thêm dòng này để kiểm tra dữ liệu trả về
                if (data.liked) {
                    heartIcon.classList.add('liked');
                } else {
                    heartIcon.classList.remove('liked');
                }
            })
            </script>
            
            
            <style>
                .fa-heart {
                    color: rgb(219, 218, 218);
                }
                .fa-heart.liked {
                    color: rgb(248, 19, 134);
                }
            </style>
            
        </div>
    </section>
    <script>
        function sortProducts(value) {
            window.location.href = value; // Chuyển hướng trang đến link được chọn
        }
    </script>
@endsection


