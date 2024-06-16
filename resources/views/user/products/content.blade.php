<?php
use App\Http\Controllers\Admin\ProductController;
?>
@extends('user.main')
@section('body')
    <section class="product">
        <div class="container">
            <div class="product-top">
                <a href="/">
                    <p>Trang chủ</p>
                </a><span>&#10230;</span>
                <a href="/danh-muc/{{ $product->menu->id }}-{{ \Str::slug($product->menu->name) }}.html">
                    <p>{{ $product->menu->name }}</p>
                </a><span>&#10230;</span>
                <p>{{ $product->name }}</p>
            </div>
            <div class="product-content">
                <?php
                    $thumbs = json_decode($product->thumb);
                    $firstThumb = $thumbs[0] ?? null;   
                    $oneThumb = $thumbs[1] ?? null;
                    $twoThumb = $thumbs[2] ?? null;
                    $threeThumb = $thumbs[3] ?? null; 
                    ?>
                <div class="product-content-left">
                    <div class="product-content-left-big-img">
                        <img src="{{ asset($firstThumb) }}" alt="">
                    </div>
                    <div class="product-content-left-small-img">
                        <img src="{{ asset($oneThumb) }}" alt="">
                        <img src="{{ asset($twoThumb) }}" alt="">
                        <img src="{{ asset($threeThumb) }}" alt="">
                    </div>
                </div>
                <div class="product-content-right">
                    <div class="product-content-right-name">
                        <h1>{{ $product->name }}</h1>
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
                    <div class="product-content-right-price">
                        <p><span style="font-weight: bold;color:black;">Giá :</span>
                            @if ($product->price_sale !== null)
                                <ins style=" text-decoration: none;"><span>{!! \App\Helpers\Helper::price($product->price_sale) !!}<sup>đ</sup></span></ins>
                                <del
                                    style="color:rgb(82, 82, 82); font-weight:lighter"><span>{!! \App\Helpers\Helper::price($product->price) !!}<sup>đ</sup></span></del>
                            @elseif($product->price_sale == null && $product->price == null)
                                <span>{!! \App\Helpers\Helper::price($product->price) !!}</span>
                            @else
                                <span>{!! \App\Helpers\Helper::price($product->price) !!}<sup>đ</sup></span>
                            @endif
                    </div>

                    @if ($product->price_sale == null && $product->price == NULL )
                           
                        @endif

                    <!-- Form để thêm san phẩm vao gio hàng -->
                    <form action="/add-cart" method="post">

                        @if ($product->price_sale !== null || $product->price !== NULL )
                            <div class="product-content-right-size">
                                <p style="font-weight: bold;">Size :
                                    <select class="size" name="size">
                                        <?php
                                    $size = ProductController::getSizeByProductId($product->id);
                                        ?>
                                        @foreach($size as $item)
                                        <option value="{{ $item->size }}">{{ $item->size }}</option>
                                        @endforeach
                                        
                                    </select>
                                </p>
                                <p style="color: red;font-size: 12px;">Vui lòng chọn size *</p>
                            </div>

                            <div class="quantity">
                                <p style="font-weight:bold">Số lượng : </p>
                                <input type="number" name="num_product" min="1" value="1">
                            </div>

                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="product_size" value="S">

                            <div class="product-content-right-button">
                                <button type="submit">
                                    <i class="fas fa-shopping-cart">
                                        <p style="padding-top: 7px;">Thêm vào giỏ hàng</p>
                                    </i>
                                </button>
                            </div>
                        @endif
                       
                        @csrf
                    </form>

                    <div class="product-content-right-bottom">
                        <div class="product-content-right-bottom-top">
                            &#8711;
                        </div>
                        <div class="product-content-right-bottom-content-big">
                            <div style="border-bottom:1px solid #e2e2e2;"  class="product-content-right-bottom-content-title">
                                <div class="product-content-right-bottom-content-title-item chitiet">
                                    <p>Mô tả chi tiết</p>
                                </div>
                                <div class="product-content-right-bottom-content-title-item baoquan">
                                    <p>Cách bảo quản</p>
                                </div>
                            </div>
                            
                            <div style="margin-top: 20px" class="product-content-right-bottom-content">
                                <div class="product-content-right-bottom-content-chitiet">
                                    <p>{!! $product->description !!}</p>
                                </div>
                                <div class="product-content-right-bottom-content-baoquan">
                                    <p>{!! $product->content !!}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        const bigImg = document.querySelector(".product-content-left-big-img img")
        const smallImg = document.querySelectorAll(".product-content-left-small-img img")
        smallImg.forEach(function(imgItem, X) {
            imgItem.addEventListener("click", function() {
                bigImg.src = imgItem.src
            })
        })
        const baoquan = document.querySelector(".baoquan")
        const chitiet = document.querySelector(".chitiet")
        if (baoquan) {
            baoquan.addEventListener("click", function() {
                document.querySelector(".product-content-right-bottom-content-chitiet").style.display = "none"
                document.querySelector(".product-content-right-bottom-content-baoquan").style.display = "block"
            })
        }
        if (baoquan) {
            baoquan.addEventListener("click", function() {
                baoquan.style.fontWeight = "bold"
                chitiet.style.fontWeight = "normal"
            })
        }
        if (chitiet) {
            chitiet.addEventListener("click", function() {
                chitiet.style.fontWeight = "bold"
                baoquan.style.fontWeight = "normal"
            })
        }
        if (chitiet) {
            chitiet.addEventListener("click", function() {
                document.querySelector(".product-content-right-bottom-content-chitiet").style.display = "block"
                document.querySelector(".product-content-right-bottom-content-baoquan").style.display = "none"
            })
        }
        const Button = document.querySelector(".product-content-right-bottom-top")
        if (Button) {
            Button.addEventListener("click", function() {
                document.querySelector(".product-content-right-bottom-content-big").classList.toggle("active")
            })
        }
    </script>
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
            border: 1px solid #e2e2e2;
            padding: 5px;
            border-radius: 20px
        }
        .fa-heart.liked {
            color: rgb(248, 19, 134);
        }
    </style>
    
@endsection
