@extends('user.main')
@section('body')
    <section class="checkout">
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
            <form class="needs-validation" name="frmthanhtoan" method="post" action="/createPaymentLink">
                @csrf
                <div class="container">
                    @php
                        $total = 0;
                    @endphp
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="user_name" value="{{ $user->name }}">

                    <div class="row">
                        <div class="col-md-4 order-md-2 mb-4">
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Giỏ hàng</span>
                                <span class="badge badge-danger badge-pill">{{ count($products) }}</span>
                            </h4>
                            <ul class="list-group mb-3">
                                @foreach ($products as $product)
                                    @php
                                        $price =
                                            $product['product']->price_sale != 0
                                                ? $product['product']->price_sale
                                                : $product['product']->price;
                                        $priceEnd = $price * $product['quantity'];
                                        $total += $priceEnd;
                                    @endphp
                                    <input type="hidden" name="sanphamgiohang[{{ $loop->index }}][id]"
                                        value="{{ $product['product']->id }}">
                                    <input type="hidden" name="sanphamgiohang[{{ $loop->index }}][name]"
                                        value="{{ $product['product']->name }}">
                                    <input type="hidden" name="sanphamgiohang[{{ $loop->index }}][thumb]"
                                        value="{{ $product['product']->thumb }}">
                                    <input type="hidden" name="sanphamgiohang[{{ $loop->index }}][quantity]"
                                        value="{{ $product['quantity'] }}">
                                    <input type="hidden" name="sanphamgiohang[{{ $loop->index }}][price]"
                                        value="{{ $price }}">
                                    <input type="hidden" name="sanphamgiohang[{{ $loop->index }}][size]"
                                        value="{{ $product['size'] }}">

                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div class="d-flex">
                                            <?php
                        $thumbs = json_decode($product['product']->thumb);
                        $firstThumb = $thumbs[0] ?? null;
                        ?>
                                            <img src="{{ asset($firstThumb) }}"
                                                alt="{{ $product['product']->name }}" class="img-thumbnail"
                                                style="width: 100px; height: auto;">
                                            <div class="ml-3">
                                                <h6 class="my-0">{{ $product['product']->name }} [
                                                    {{ $product['size'] }} ] </h6>
                                                <small
                                                    class="text-muted">{{ number_format($price, 0, ',', '.') }}<sup>đ</sup>
                                                    x
                                                    {{ $product['quantity'] }}</small>
                                            </div>
                                        </div>
                                        <span
                                            class="text-muted">{{ number_format($priceEnd, 0, ',', '.') }}<sup>đ</sup></span>
                                    </li>
                                @endforeach
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Tổng thành tiền</span>
                                    <strong>{{ number_format($total, 0, ',', '.') }}<sup>đ</sup></strong>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-8 order-md-1">
                            <h4 class="mb-3">Thông tin khách hàng</h4>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="name">Họ tên</label>
                                    <input style="background-color:rgb(243, 243, 242)" type="text" class="form-control"
                                        name="name" id="name" value="" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="address">Địa chỉ</label>
                                    <input style="background-color:rgb(243, 243, 242)" type="text" class="form-control"
                                        name="address" id="address" value="" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="phone">Điện thoại</label>
                                    <input style="background-color:rgb(243, 243, 242)" type="text" class="form-control"
                                        name="phone" id="phone" value="" required pattern="[0-9]{10,11}">
                                </div>
                                <div class="col-md-12">
                                    <label for="email">Email</label>
                                    <input style="background-color:rgb(243, 243, 242)" type="email" class="form-control"
                                        name="email" id="email" value="" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="content">Ghi chú</label>
                                    <textarea class="form-control" name="content" id="content" value=""></textarea>
                                </div>
                            </div>

                            <h4 class="mb-3">Hình thức thanh toán</h4>

                            <div class="d-block my-3">
                                <div class="custom-control custom-radio">
                                    <input id="pay-1" name="pay_method" type="radio" class="custom-control-input"
                                        required="" value="1" checked>
                                    <label class="custom-control-label" for="pay-1">Tiền mặt</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input id="pay-2" name="pay_method" type="radio" class="custom-control-input"
                                        required="" value="2">
                                    <label class="custom-control-label" for="pay-2">Chuyển khoản</label>
                                </div>
                            </div>
                            <hr class="mb-4">
                            <button class="btn btn-primary btn-lg btn-block" type="submit" name="btnDatHang">Đặt
                                hàng</button>
                        </div>
                    </div>


                </div>
                <div>
                    <input type="hidden" value="{{ $total }}" name="amount">
                </div>
            </form>
        @else
            <div class="text-center">
                <h2>Vui lòng thêm sản phẩm vào giỏ hàng để tiếp tục đặt hàng</h2>
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
@endsection
