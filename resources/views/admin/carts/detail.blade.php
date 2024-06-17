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
                <th>Trạng thái đơn hàng</th>
            </tr>

            @foreach ($carts as $cart)
            @php
                $priceEnd = $cart->price * $cart->qty;
                $total += $priceEnd;
            @endphp
            <?php
            $thumbs = json_decode($cart->thumb);
            $firstThumb = $thumbs[0] ?? null;
            ?>
                <tr>
                    <td>
                            <img src="{{ asset($firstThumb) }}" alt="{{ $cart->name }}"></a>
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
                    <td>
                        <form class="d-flex justify-content-between" action="{{ route('cart_status') }}" method="get">
                        <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                        <select class="form-control w-75"  name="cart_status" id="">
                                <option @if($cart->cart_status == 0) selected @endif value="0">Chờ lấy hàng</option>
                                <option @if($cart->cart_status == 1) selected @endif value="1">Đang giao hàng</option>
                                <option @if($cart->cart_status == 2) selected @endif  value="2">Đã giao hàng</option>
                                <option @if($cart->cart_status == 3) selected @endif value="3">Đơn hàng đã hủy</option>
                        </select>
                        <button class="btn btn-primary" type="submit">Thay đổi</button>
                    </form>
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
