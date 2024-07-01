@extends('user.main')
@section('body')
    <section class="cart">
        @include('login.alert')
        <div class="customer mt-3">
            <ul>
                <li>Tên khách hàng: <strong>{{ $customer[0]->customer_name }}</strong></li>
                <li>Số điện thoại <strong>{{ $customer[0]->phone }}</strong></li>
                <li>Email: <strong>{{ $customer[0]->email }}</strong></li>
                <li>Địa chỉ: <strong>{{ $customer[0]->address }}</strong></li>
                <li>Ghi chú: <strong>{{ $customer[0]->content }}</strong></li>
            </ul>
        </div>
        <div class="carts">
            @php
                $total = 0;
                
            @endphp
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="w-25">Sản phẩm</th>
                    <th>Tên sản phẩm </th>
                    <th>Size</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Tổng tiền SP</th>
                    <th>Trạng thái đơn hàng</th>
                </tr>
            </thead>
                @foreach ($customer as $cart)
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
                                <img  class="w-25" src="{{ asset($firstThumb) }}" alt="{{ $cart->name }}"></a>
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
                        <td class="">
                            <div class="d-flex justify-content-between">
                            <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                            @if($cart->cart_status == 0)
                            <p class="font-weight-bold mb-0 text-white px-2" style="background: rgb(113, 0, 128); border-radius: 10px">Chờ lấy hàng</p>
                            @endif

                            @if($cart->cart_status == 1)
                            <p class="font-weight-bold mb-0 text-white px-2" style="background: rgb(0, 32, 128); border-radius: 10px"> Đang giao hàng</p>
                            @endif

                            @if($cart->cart_status == 2)
                            <p class="font-weight-bold mb-0 text-white px-2" style="background: rgb(32, 128, 0); border-radius: 10px"> Đã giao hàng</p>
                            
                            @endif

                            @if($cart->cart_status == 3)
                            <p class="font-weight-bold mb-0 text-white px-2" style="background: rgb(128, 0, 23); border-radius: 10px">Đơn hàng đã hủy</p>
                            @endif
                            </div>
                       
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="cart-content-right">
            @if($customer[0]->pay_method == 2)
            <div>
                <h3 class="font-weight-bold">Số tiền bạn đã chuyển khoản</h3>
                <div class="d-flex ">
                    <p class="mr-3 font-weight-bold">Tổng tiền hàng</p>
                    <p class="font-weight-bold">{{ number_format($total, 0, ',', '.') }} <sup>đ</sup></p>
                </div>

                <div class="d-flex ">
                    <p class="mr-3 font-weight-bold">Đã thanh toán</p>
                    <p style="color: black;font-weight: bold;">
                        {{ number_format($total, 0, ',', '.') }}<sup> đ</sup></p>
                </div>
            </div>
            @else

            <div>
                <h3 class="font-weight-bold"></h3>
                <div class="d-flex ">
                    <p class="mr-3 font-weight-bold">Tổng tiền hàng</p>
                    <p class="font-weight-bold">{{ number_format($total, 0, ',', '.') }} <sup>đ</sup></p>
                </div>

                <div class="d-flex ">
                    <p class="mr-3 font-weight-bold">Tổng tiền :</p>
                    <p style="color: black;font-weight: bold;">
                        {{ number_format($total, 0, ',', '.') }}<sup> đ</sup></p>
                </div>
            </div>
            
            @endif
        </div>
    </section>
@endsection
