@extends('user.main')
@section('body')

    <section class="cart">
        @include('login.alert')
        <div class="cart-top-wrap">
            <div class="cart-top">
                <a href="/carts">
                    <div class="cart-top-cart cart-top-item">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </a>
                <a href="/checkouts">
                    <div class="cart-top-adress cart-top-item">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                </a>
                <a href="#">
                    <div class="cart-top-payment cart-top-item">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                </a>
            </div>
        </div>

        @if (count($products) > 0)
            <div class="cart-content">
                <div class="cart-content-left">
                    @php
                        $total = 0;
                    @endphp
                    <table>

                        <tr class="list_cart_session">
                            <th>Sản phẩm</th>
                            <th>Tên sản phẩm </th>
                            <th>Size</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Tổng tiền SP</th>
                            <th>Xóa SP</th>
                        </tr>
                        
                        @foreach ($products as $cartProduct)
                        <?php
                        $thumbs = json_decode($cartProduct['product']->thumb);
                        $firstThumb = $thumbs[0] ?? null;
                        ?>
                            @php
                                $price =
                                    $cartProduct['product']->price_sale != 0
                                        ? $cartProduct['product']->price_sale
                                        : $cartProduct['product']->price;
                                $priceEnd = $price * $cartProduct['quantity'];
                                $total += $priceEnd;
                            @endphp
                            <tr class="list_cart_product">
                                <td><a
                                        href="/san-pham/{{ $cartProduct['product']->id }}-{{ \Str::slug($cartProduct['product']->name, '-') }}.html">
                                        <img style="border-radius: 10px " src="{{ asset($firstThumb) }}"
                                            alt="{{ $cartProduct['product']->name }}"></a>
                                </td>
                                <td>
                                    <a href="/san-pham/{{ $cartProduct['product']->id }}-{{ \Str::slug($cartProduct['product']->name, '-') }}.html">
                                        <p style="color: rgb(32, 32, 32)">{{ $cartProduct['product']->name }}</p>
                                    </a>
                                </td>
                                <td>
                                    <p>{{ $cartProduct['size'] }}</p>
                                    <input type="hidden"
                                        name="products[{{ $cartProduct['product']->id }}][{{ $cartProduct['size'] }}][size]"
                                        value="{{ $cartProduct['size'] }}">
                                </td>
                                <td>
                                    <form action="" method="post">
                                        @csrf
                                        <input
                                            name="products[{{ $cartProduct['product']->id }}][{{ $cartProduct['size'] }}][quantity]"
                                            type="number" value="{{ $cartProduct['quantity'] }}" min="1"
                                            style="width: 50px">
                                        <button
                                            style="width: 30px;background-color: rgb(255, 255, 255); font-size: 15px; border:none; text-align: center;"
                                            type="submit" formaction="/update-cart">
                                            <i style="color:rgb(131, 253, 131)" class="fas fa-edit"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <p>{{ number_format($price, 0, ',', '.') }} <sup>đ</sup></p>
                                </td>
                                <td>
                                    <p>{{ number_format($priceEnd, 0, ',', '.') }} <sup>đ</sup></p>
                                </td>
                                <td>
                                    <form action="{{ route('cart.remove') }}" method="post">

                                        <input type="hidden" name="product_id" value="{{ $cartProduct['product']->id }}">
                                        <input type="hidden" name="size" value="{{ $cartProduct['size'] }}">
                                        <button type="submit" class="remove-product">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </table>


                </div>
                <div class="cart-content-right">
                    @php
                        $totalQuantity = 0;

                        foreach ($carts as $item) {
                            $totalQuantity += $item['quantity'];
                        }
                    @endphp
                    <table>
                        <tr>
                            <th colspan="2">Tổng tiền trong giỏ hàng</th>
                        </tr>
                        <tr>
                            <td class="font-weight-bold" style="font-size:20px ">Tổng số sản phẩm </td>
                            <td class="font-weight-bold" style="font-size:20px ">{{ $totalQuantity }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold" style="font-size:20px ">Tổng tiền hàng</td>
                            <td class="font-weight-bold" style="font-size:20px ">

                                <p class="mb-0">{{ number_format($total, 0, ',', '.') }} <sup>đ</sup></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold" style="font-size:20px ">Tạm tính</td>
                            <td class="font-weight-bold" style="font-size:20px ">
                                <p style="color: black;font-weight: bold;">
                                    {{ number_format($total, 0, ',', '.') }}<sup> đ</sup></p>
                            </td>
                        </tr>
                    </table>
                    <div class="cart-content-right-text">
                        <p class="font-weight-bold" style="font-size:20px;color: red; ">* Miễn phí ship với hóa đơn trên 1.000.000 <sup>đ</sup> . @if ($total < 1000000)
                                Mua thêm {{ number_format(1000000 - $total, 0, ',', '.') }}<sup>đ</sup> để được miễn phí
                                ship
                            @endif
                        </p>

                    </div>

                    <div class="cart-content-right-button">
                        <a href="/"><button>TIẾP TỤC MUA SẮM </button></a>
                        <a href="/checkouts"><button style="margin-top:5px">THANH TOÁN</button></a>
                    </div>

                </div>
            </div>
        @else
            <div class="text-center">
                <h2>Không có sản phẩm trong giỏ hàng</h2>
            </div>
        @endif
    </section>
    @if (session()->has('success'))
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".alert-success").fadeOut("slow");
                }, 5000); // Thay đổi bằng số miligiây bạn muốn thông báo hiển thị
            });
        </script>
    @endif
    <style>
        .cart-content table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px; /* Khoảng cách giữa các hàng */
        }
    </style>
@endsection
