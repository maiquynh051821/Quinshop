<?php
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\ProductshopController;
?>
@extends('user.main')
@section('body')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                            @if (Auth::check())
                                <!-- Kiểm tra xem có người dùng đã đăng nhập hay không -->
                                <form method="post" action="{{ route('products.like', $product->id) }}">
                                    @csrf
                                    <button style="border: none; background-color: transparent" type="submit">
                                        <i
                                            class="fas fa-heart {{ Auth::user()->favoriteProducts->contains($product->id) ? 'liked' : '' }}"></i>
                                    </button>
                                </form>
                            @else
                                <button style="border: none;background-color:transparent" type="button"
                                    class="login-prompt">
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

                    @if ($product->price_sale == null && $product->price == null)
                    @endif

                    <!-- Form để thêm san phẩm vao gio hàng -->
                    <form action="/add-cart" method="post">

                        @if ($product->price_sale !== null || $product->price !== null)
                            <div class="product-content-right-size">
                                <p style="font-weight: bold;">Size :
                                    <select class="size" name="size">
                                        <?php
                                        $size = ProductController::getSizeByProductId($product->id);
                                        ?>
                                        @foreach ($size as $item)
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
                            <div style="border-bottom:1px solid #e2e2e2;"
                                class="product-content-right-bottom-content-title">
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

        <div>
            <?php
            $comment = ProductshopController::getCommnet($product->id);
            $sumStar = 0;
            $number = 0;
            foreach ($comment as $key => $value) {
                $sumStar += $value->star;
                $number += 1;
            }
            if ($number != 0) {
                $rating = $sumStar / $number;
            } else {
                $rating = 0;
            }
            ?>
            <div class="d-flex align-items-center">
                <h3 class="font-weight-bold mt-4 text-uppercase">Bình luận</h3>
                <div class="">
                    <div class="rating0">
                        <input type="radio" @if ($rating > 4 && $rating <= 5 || $rating <= 0 ) checked @endif name="rating" id="rating0-5"
                            value="5">
                        <label for="rating0-5"></label>
                        <input type="radio" @if ($rating > 3 && $rating <= 4) checked @endif name="rating" id="rating0-4"
                            value="4">
                        <label for="rating0-4"></label>
                        <input type="radio" @if ($rating > 2 && $rating <= 3) checked @endif name="rating" id="rating0-3"
                            value="3">
                        <label for="rating0-3"></label>
                        <input type="radio" @if ($rating > 1 && $rating <= 2) checked @endif name="rating" id="rating0-2"
                            value="2">
                        <label for="rating0-2"></label>
                        <input type="radio" @if ($rating <= 1 && $rating > 0) checked @endif name="rating" id="rating0-1"
                            value="1">
                        <label for="rating0-1"></label>
                    </div>
                </div>
            </div>
            <style>
                .checked {
                    color: #FCD93A;
                }

                .aa{
                    color: #E3E3E3;
                }
            </style>
            <ul>
                @foreach ($comment as $commentItem)
                    <?php
                    $userName = ProductshopController::getNameUser($commentItem->user_id);
                    $star = $commentItem->star;
                    ?>
                    <div style="border-bottom: 2px solid #ccc" class="mb-2">
                        <p class="mb-2">{!! $userName !!}</p>
                        <div class="ml-5">
                            <p class="mb-2">
                                @if ($star == 1)
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star aa"></span>
                                    <span class="fa fa-star aa"></span>
                                    <span class="fa fa-star aa"></span>
                                    <span class="fa fa-star aa"></span>
                                @endif

                                @if ($star == 2)
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star aa"></span>
                                    <span class="fa fa-star aa"></span>
                                    <span class="fa fa-star aa"></span>
                                @endif

                                @if ($star == 3)
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star aa"></span>
                                    <span class="fa fa-star aa"></span>
                                @endif

                                @if ($star == 4)
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star aa"></span>
                                @endif

                                @if ($star == 5)
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                @endif

                            </p>
                            <p class="text-uppercase">{{ $commentItem->COMMENT }}</p>
                        </div>
                    </div>
                @endforeach
                <li></li>
            </ul>
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
                button.addEventListener('click', function() {
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
            console.log(data); // Thêm dòng này để kiểm tra dữ liệu trả về
            if (data.liked) {
                heartIcon.classList.add('liked');
            } else {
                heartIcon.classList.remove('liked');
            }
        })
    </script>


    <style>
        .product {
            padding-bottom: 20px;
        }

        .fa-heart {
            color: rgb(219, 218, 218);
            border: 1px solid #e2e2e2;
            padding: 5px;
            border-radius: 20px
        }

        .fa-heart.liked {
            color: rgb(248, 19, 134);
        }

        .rating0 {
            display: flex;
            width: 100%;
            justify-content: center;
            overflow: hidden;
            flex-direction: row-reverse;
            position: relative;
            margin-top: 20px;
            margin-left: 10px;
        }


        .rating0>input {
            display: none;
        }

        .rating0>label {
            cursor: pointer;
            width: 40px;
            height: 40px;
            margin-top: auto;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='126.729' height='126.73'%3e%3cpath fill='%23e3e3e3' d='M121.215 44.212l-34.899-3.3c-2.2-.2-4.101-1.6-5-3.7l-12.5-30.3c-2-5-9.101-5-11.101 0l-12.4 30.3c-.8 2.1-2.8 3.5-5 3.7l-34.9 3.3c-5.2.5-7.3 7-3.4 10.5l26.3 23.1c1.7 1.5 2.4 3.7 1.9 5.9l-7.9 32.399c-1.2 5.101 4.3 9.3 8.9 6.601l29.1-17.101c1.9-1.1 4.2-1.1 6.1 0l29.101 17.101c4.6 2.699 10.1-1.4 8.899-6.601l-7.8-32.399c-.5-2.2.2-4.4 1.9-5.9l26.3-23.1c3.8-3.5 1.6-10-3.6-10.5z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 76%;
            transition: 0.3s;
        }

        .rating0>input:checked~label {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='126.729' height='126.73'%3e%3cpath fill='%23fcd93a' d='M121.215 44.212l-34.899-3.3c-2.2-.2-4.101-1.6-5-3.7l-12.5-30.3c-2-5-9.101-5-11.101 0l-12.4 30.3c-.8 2.1-2.8 3.5-5 3.7l-34.9 3.3c-5.2.5-7.3 7-3.4 10.5l26.3 23.1c1.7 1.5 2.4 3.7 1.9 5.9l-7.9 32.399c-1.2 5.101 4.3 9.3 8.9 6.601l29.1-17.101c1.9-1.1 4.2-1.1 6.1 0l29.101 17.101c4.6 2.699 10.1-1.4 8.899-6.601l-7.8-32.399c-.5-2.2.2-4.4 1.9-5.9l26.3-23.1c3.8-3.5 1.6-10-3.6-10.5z'/%3e%3c/svg%3e");
        }



        .emoji-wrapper {
            width: 100%;
            text-align: center;
            height: 100px;
            overflow: hidden;
            position: absolute;
            top: 0;
            left: 0;
        }

        .emoji-wrapper:before,
        .emoji-wrapper:after {
            content: "";
            height: 15px;
            width: 100%;
            position: absolute;
            left: 0;
            z-index: 1;
        }

        .emoji-wrapper:before {
            top: 0;
            background: linear-gradient(to bottom, white 0%, white 35%, rgba(255, 255, 255, 0) 100%);
        }

        .emoji-wrapper:after {
            bottom: 0;
            background: linear-gradient(to top, white 0%, white 35%, rgba(255, 255, 255, 0) 100%);
        }

        .emoji {
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: 0.3s;
        }

        .emoji>svg {
            margin: 15px 0;
            width: 70px;
            height: 70px;
            flex-shrink: 0;
        }

        /* end lan 1 */
    </style>

@endsection
