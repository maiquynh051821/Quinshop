@extends('admin.main')
@section('content')
    <style>
        table {
            border-collapse: collapse;
            /* Kết hợp đường viền giữa các ô */
            width: 100%;
            /* Đảm bảo bảng chiếm toàn bộ chiều rộng */
        }

        th,
        td {
            border: 1px solid rgb(252, 207, 207);
            /* Đặt đường viền 1px đen cho các ô */
            padding: 8px;
        }
        .others button {
    background-color: #007bff;
    border: 1px solid #ccc;
    border-left: none;
    color: #fff;
    padding: 8px 15px;
    border-radius: 0 5px 5px 0;
    cursor: pointer;
    transition: background-color 0.3s;
}

.others {
    display: flex;
    align-items: center;
    margin-left: auto;
}

.others input[type="text"] {
    padding: 8px 10px;
    border: 1px solid #ccc;
    border-radius: 5px 0 0 5px;
    outline: none;
    border-right: none;
}
    </style>
    <div class="py-3 mr-3 d-flex justify-content-end">
        <form action="{{ route('search_comment') }}" method="get">
          <div class="others">
              <input name="name_product" placeholder="Tìm kiếm sản phẩm" type="text">
              <button type="submit"><i class="fas fa-search" aria-hidden="true"></i></button>
          </div>
      </form>
      </div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 70px;text-align:center;">STT</th>
                <th style="width: 150px;text-align:center;">Tên Sản Phẩm </th>
                <th style="text-align:center;width: 200px;">Ảnh</th>
                <th style="width: 350px;text-align:center;">Bình luận</th>
                <th style="width: 150px;text-align:center;">Số sao</th>
                <th style="width: 150px;text-align:center;">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $key => $product)
                <tr>
                    <td style="text-align:center;">{{ $loop->iteration }}</td>
                    <td style="padding-left:20px">{{ $product->name }}</td>
                    <?php
                    $thumbs = json_decode($product->thumb);
                    $firstThumb = $thumbs[0] ?? null;
                    ?>
                    <td style="text-align:center"><a>
                            <img style="width: 100px;height:auto" src="{{ asset($firstThumb) }}" alt="Thumbnail"
                                class="img-thumbnail"></a>
                    </td>
                    <td style="text-align:center;">{{ $product->COMMENT }} </td>
                    <td>
                        <p class="mb-2">
                            @if ($product->star == 1)
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star aa"></span>
                                <span class="fa fa-star aa"></span>
                                <span class="fa fa-star aa"></span>
                                <span class="fa fa-star aa"></span>
                            @endif

                            @if ($product->star == 2)
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star aa"></span>
                                <span class="fa fa-star aa"></span>
                                <span class="fa fa-star aa"></span>
                            @endif

                            @if ($product->star == 3)
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star aa"></span>
                                <span class="fa fa-star aa"></span>
                            @endif

                            @if ($product->star == 4)
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star aa"></span>
                            @endif

                            @if ($product->star == 5)
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                            @endif

                        </p>
                    </td>
                    <td style="text-align:center;"><a href="{{ route('status_comment', ['id' => $product->comment_id]) }}">
                            @if ($product->STATUS == 1)
                                <span class="px-2 font-weight-bold" style="    background-color: rgba(25, 135, 84, .1);
    color: #198754;border-radius: 5px">Đang
                                    Mở</span>
                            @else
                                <span class="px-2 font-weight-bold" style="background-color: rgba(220, 53, 69, .1);
    color: #dc3545;border-radius: 5px">
                                    Đã Đóng
                                </span>
                            @endif
                        </a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- Phan trang --}}
    {{ $products->links() }}
    <style>
        .checked {
            color: #FCD93A;
        }

        .aa {
            color: #E3E3E3;
        }
    </style>
@endsection
