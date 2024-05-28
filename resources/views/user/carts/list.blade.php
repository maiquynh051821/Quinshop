@extends('user.main')
@section('body')
<form action="">
    <section class="cart">
      
        <div class="cart-top-wrap">
            <div class="cart-top">
                <div class="cart-top-cart cart-top-item">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="cart-top-adress cart-top-item">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="cart-top-payment cart-top-item">
                    <i class="fas fa-money-check-alt"></i>
                </div>
            </div>
        </div>


        @if(count($products) > 0)

        <div class="cart-content">
            <div class="cart-content-left">
                <table>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Tên sản phẩm </th>
                        <th>Size</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền SP</th>
                        <th>Xóa SP</th>
                    </tr>
                    @foreach($products as $cartProduct)
                    <tr>
                        <td><img src="{{ $cartProduct['product']->thumb }}" alt="{{ $cartProduct['product']->name }}"></td>
                        <td>
                            <p>{{ $cartProduct['product']->name }}</p>
                        </td>
                        <td>
                            <p>{{ $cartProduct['size'] }}</p>
                        </td>
                        <td><input type="number" value="{{ $cartProduct['quantity'] }}" min="1" style="width: 70px"></td>
                        <td>
                            <p>{{ number_format($cartProduct['total_price'], 0, ',', '.') }} <sup>đ</sup></p>
                        </td>
                        <td>
                            <span>X</span>
                        </td>
                    </tr>
                    @endforeach

                </table>
            </div>
            <div class="cart-content-right">
                <table>
                    <tr>
                        <th colspan="2">Tổng tiền trong giỏ hàng</th>
                    </tr>
                    <tr>
                        <td>Tổng sản phẩm </td>
                        <td>{{ count($products) }}</td>
                    </tr>
                    <tr>
                        <td>Tổng tiền hàng</td>
                        <td>
                            @php
                            $total = 0;
                            foreach ($products as $cartProduct) {
                                $total += $cartProduct['total_price'];
                            }
                        @endphp
                        <p>{{ number_format($total, 0, ',', '.') }} <sup>đ</sup></p>
                        </td>
                    </tr>
                    <tr>
                        <td>Tạm tính</td>
                        <td>
                            <p style="color: black;font-weight: bold;">{{ number_format($total, 0, ',', '.') }}<sup> đ</sup></p>
                        </td>
                    </tr>
                </table>
                <div class="cart-content-right-text">
                    <p style="color: red;">* Miễn phí ship với hóa đơn trên 1.000.000 <sup>đ</sup></p>
                </div>
                <div class="cart-content-right-button">
                    <a href="category.html"><button>TIẾP TỤC MUA SẮM </button></a>
                    <button style="margin-top:5px">ĐẶT MUA</button>
                </div>

            </div>
        </div>

        @else
        <div class="text-center"><h2>Không có sản phẩm trong giỏ hàng</h2></div>
        @endif
</section>
</form>
   
@endsection
