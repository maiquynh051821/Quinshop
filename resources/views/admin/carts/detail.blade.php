@extends('admin.main')
@section('content')
    <div class="customer mt-3">
        <ul>
            <li>Tên khách hàng: <strong>{{ $customer->name }}</strong></li>
            <li>Số điện thoại <strong>{{ $customer->phone }}</strong></li>
            <li>Email: <strong>{{ $customer->email }}</strong></li>
            <li>Địa chỉ: <strong>{{ $customer->address }}</strong></li>
            <li>Ghi chú: <strong>{{ $customer->content }}</strong></li>
        </ul>
    </div>
    <div class="carts">
        @php
            $total = 0;
            
        @endphp
        <table>

            <tr>
                <th>Sản phẩm</th>
                <th>Tên sản phẩm </th>
                <th>Size</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Tổng tiền SP</th>
            </tr>

            @foreach ($carts as $cart)
            @php
                $priceEnd = $cart->price * $cart->qty;
                $total += $priceEnd;
            @endphp
                <tr>
                    <td>
                            <img src="{{ $cart->thumb }}" alt="{{ $cart->name }}"></a>
                    </td>
                    <td>
                        <p>{{ $cart->name }}</p>
                    </td>
                    <td>
                        <p>{{ $cart->size }}</p>
                    </td>
                    <td>
                        <p>{{ $cart->qty }}</p>
                    </td>
                    <td>
                        <p>{{ number_format($cart->price, 0, ',', '.') }} <sup>đ</sup></p>
                    </td>
                    <td>
                        <p>{{ number_format($priceEnd, 0, ',', '.') }} <sup>đ</sup></p>
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
                <td>Tổng tiền hàng</td>
                <td>
                    <p>{{ number_format($total, 0, ',', '.') }} <sup>đ</sup></p>
                </td>
            </tr>
            <tr>
                <td>Tạm tính</td>
                <td>
                    <p style="color: black;font-weight: bold;">
                        {{ number_format($total, 0, ',', '.') }}<sup> đ</sup></p>
                </td>
            </tr>
        </table>
    </div>
@endsection
