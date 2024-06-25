<!DOCTYPE html>
<html>
<head>
    <title>Xác Nhận Đơn Hàng</title>
</head>
<body>
   @php
        $total_amount = 0;
   @endphp
    <h1>Cảm ơn bạn đã đặt hàng, {{ $customer->name }}!</h1>
    <p>Chúng tôi đã nhận được đơn hàng của bạn và đang tiến hành xử lý. Dưới đây là chi tiết đơn hàng của bạn:</p>

    
    <h2>Sản Phẩm</h2>
    <ul>
        @foreach ($updatedCarts as $cart)
            <li>
                {{ $cart['name'] }} (Size: {{ $cart['size'] }}) :
                {{ $cart['quantity'] }} x 
                {{ number_format($cart['price'], 0, ',', '.') }} VND
            </li>
            @php

                $price_End = $cart['price'] * $cart['quantity'];
                $total_amount += $price_End;
            @endphp
        @endforeach
    </ul>

    <p><strong>Tổng Số Tiền:</strong> {{ number_format($total_amount, 0, ',', '.') }} VND</p>


    {{-- "pivot" là một đối tượng đặc biệt được sử dụng để truy cập vào các cột trong bảng trung gian (pivot table) khi làm việc với các quan hệ nhiều-nhiều (many-to-many) giữa các model. --}}
    <p>Chúng tôi sẽ thông báo cho bạn khi đơn hàng của bạn được giao. Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!</p>
    <p>Trân trọng,</p>
    <p>Quin-Shop</p>
</body>
</html>
