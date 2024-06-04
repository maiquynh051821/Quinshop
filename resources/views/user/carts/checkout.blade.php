@extends('user.main')
@section('body')
    <section class="checkout">
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
        <div class="container">
            @php
                $total = 0;
            @endphp
            <form class="needs-validation" name="frmthanhtoan" method="post" action="#">
                <input type="hidden" name="kh_tendangnhap" value="dnpcuong">

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
                                <input type="hidden" name="sanphamgiohang[{{ $loop->index }}][sp_ma]"
                                    value="{{ $product['product']->id }}">
                                <input type="hidden" name="sanphamgiohang[{{ $loop->index }}][gia]"
                                    value="{{ $product['product']->price }}">
                                <input type="hidden" name="sanphamgiohang[{{ $loop->index }}][soluong]"
                                    value="{{ $product['product']->quantity }}">

                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div class="d-flex">
                                        <img src="{{ $product['product']->thumb }}" alt="{{ $product['product']->name }}"
                                            class="img-thumbnail" style="width: 100px; height: auto;">
                                        <div class="ml-3">
                                            <h6 class="my-0">{{ $product['product']->name }}</h6>
                                            <small class="text-muted">{{ number_format($price, 0, ',', '.') }}<sup>đ</sup> x
                                                {{ $product['quantity']}}</small>
                                        </div>
                                    </div>
                                    <span class="text-muted">{{ number_format($priceEnd, 0, ',', '.') }}<sup>đ</sup></span>
                                </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tổng thành tiền</span>
                                <strong>{{ number_format($total, 0, ',', '.')}}<sup>đ</sup></strong>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8 order-md-1">
                        <h4 class="mb-3">Thông tin khách hàng</h4>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="kh_ten">Họ tên</label>
                                <input type="text" class="form-control" name="kh_ten" id="kh_ten" value=""
                                    readonly="">
                            </div>
                            <div class="col-md-12">
                                <label for="kh_diachi">Địa chỉ</label>
                                <input type="text" class="form-control" name="kh_diachi" id="kh_diachi" value=""
                                    readonly="">
                            </div>
                            <div class="col-md-12">
                                <label for="kh_dienthoai">Điện thoại</label>
                                <input type="text" class="form-control" name="kh_dienthoai" id="kh_dienthoai"
                                    value="" readonly="">
                            </div>
                            <div class="col-md-12">
                                <label for="kh_email">Email</label>
                                <input type="text" class="form-control" name="kh_email" id="kh_email" value=""
                                    readonly="">
                            </div>
                        </div>

                        <h4 class="mb-3">Hình thức thanh toán</h4>

                        <div class="d-block my-3">
                            <div class="custom-control custom-radio">
                                <input id="httt-1" name="httt_ma" type="radio" class="custom-control-input"
                                    required="" value="1">
                                <label class="custom-control-label" for="httt-1">Tiền mặt</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="httt-2" name="httt_ma" type="radio" class="custom-control-input"
                                    required="" value="2">
                                <label class="custom-control-label" for="httt-2">Chuyển khoản</label>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit" name="btnDatHang">Đặt
                            hàng</button>
                    </div>
                </div>
            </form>

        </div>

    </section>
@endsection
