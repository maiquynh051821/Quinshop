<?php
use App\Http\Controllers\User\CartshopController;
?>
@extends('user.main')
@section('body')
    <section class="cart">
        @include('login.alert')
        @foreach ($customer as $customerItems)
            <div class="customer mt-3">
                <ul>
                    <li>Tên khách hàng: <strong>{{ $customerItems->name }}</strong></li>
                    <li>Số điện thoại <strong>{{ $customerItems->phone }}</strong></li>
                    <li>Email: <strong>{{ $customerItems->email }}</strong></li>
                    <li>Địa chỉ: <strong>{{ $customerItems->address }}</strong></li>
                    <li>Ghi chú: <strong>{{ $customerItems->content }}</strong></li>
                </ul>
            </div>
            <?php
            $carts = CartshopController::getCart($customerItems->id);
            ?>
            <div class="carts">
                @php
                    $total = 0;
                @endphp
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 18%;">Sản phẩm</th>
                            <th>Tên sản phẩm </th>
                            <th>Size</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Tổng tiền SP</th>
                            <th>Trạng thái đơn hàng</th>
                            <th style="width: 12%;">Hủy đơn hàng</th>
                        </tr>
                    </thead>
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
                                <img class="w-25" src="{{ asset($firstThumb) }}" alt="{{ $cart->name }}"></a>
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
                                <div class="d-flex">
                                    <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                                    @if ($cart->cart_status == 1)
                                        <p class="font-weight-bold mb-0 text-white px-2"
                                            style="background: rgb(113, 0, 128); border-radius: 10px">Chờ lấy hàng</p>
                                    @endif

                                    @if ($cart->cart_status == 1)
                                        <p class="font-weight-bold mb-0 text-white px-2"
                                            style="background: rgb(0, 32, 128); border-radius: 10px"> Đang giao hàng</p>
                                    @endif

                                    @if ($cart->cart_status == 0)
                                        <p class="font-weight-bold mb-0 text-white px-2 mr-2"
                                            style="background: rgb(32, 128, 0); border-radius: 10px"> Đã giao hàng</p>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#comment{{ $cart->id }}">Nhận xét</button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="comment{{ $cart->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Nhận xét 
                                                                {{ $cart->name }}</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="star-rating" data-id="{{ $cart->id }}">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i class="fa-star {{ $i <= ($cart->star ?? 0) ? 'fas' : 'far' }}" data-value="{{ $i }}"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Đóng</button>
                                                            <button type="button" class="btn btn-primary">Lưu</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($cart->cart_status == 3)
                                        <p class="font-weight-bold mb-0 text-white px-2"
                                            style="background: rgb(128, 0, 23); border-radius: 10px">Đơn hàng đã hủy</p>
                                    @endif
                                </div>

                            </td>

                            <td><a class="font-weight-bold" href="">Hủy đơn hàng</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endforeach
    </section>
    <script>
        $(document).ready(function() {
            $('.rating').rating({
                showClear: false,
                showCaption: false
            });
        
            $('.rating').on('rating:change', function(event, value, caption) {
                var cartId = $(this).attr('id').split('-')[1];
        
                $.ajax({
                    url: '',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        cart_id: cartId,
                        rating: value
                    },
                    success: function(response) {
                        alert('Rating saved!');
                    }
                });
            });
        });
        </script>
@endsection
