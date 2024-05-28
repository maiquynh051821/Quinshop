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
                <div class="product-content-left">
                    <div class="product-content-left-big-img">
                        <img src="{{ $product->thumb }}" alt="">
                    </div>
                    <div class="product-content-left-small-img">
                        <img src="/template/images/product-02.jpg" alt="">
                        <img src="/template/images/product-03.jpg" alt="">
                        <img src="/template/images/product-05.jpg" alt="">
                    </div>
                </div>
                <div class="product-content-right">
                    <div class="product-content-right-name">
                        <h1>{{ $product->name }}</h1>
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
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
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
                            <div class="product-content-right-bottom-content-title">
                                <div class="product-content-right-bottom-content-title-item chitiet">
                                    <p>Mô tả chi tiết</p>
                                </div>
                                <div class="product-content-right-bottom-content-title-item baoquan">
                                    <p>Cách bảo quản</p>
                                </div>
                            </div>
                            <div class="product-content-right-bottom-content">
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
@endsection
