@extends('admin.main')
@section('content')
<style>

  table {
        border-collapse: collapse; /* Kết hợp đường viền giữa các ô */
        width: 100%; /* Đảm bảo bảng chiếm toàn bộ chiều rộng */
    }
    th, td {
        border: 1px solid rgb(252, 207, 207); /* Đặt đường viền 1px đen cho các ô */
        padding: 8px;
    }
 
</style>
    <table class="table">
      <thead>
        <tr>
          <th style="width: 70px;text-align:center;">STT</th>
          <th style="width: 350px;text-align:center;">Tên Sản Phẩm </th>
          <th style="width: 350px;text-align:center;">Danh Mục </th>
          <th style="text-align:center;width: 200px;">Ảnh</th>
          <th style="text-align:center;">Active</th>
          <th style="width: 450px;text-align:center;">Bình luận + đánh giá</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $key => $product)
        <tr>
            <td style="text-align:center;">{{$loop->iteration}}</td>
            <td style="padding-left:20px">{{$product->name}}</td>
            <td style="padding-left:20px">{{optional($product->menu)->name}}</td>
            <?php
                 $thumbs = json_decode($product->thumb);
                  $firstThumb = $thumbs[0] ?? null;   
                ?>
            <td style="text-align:center"><a href="{{ $product->thumb }}">
              <img style="width: 70px;height:auto" src="{{ asset($firstThumb) }}" alt="Thumbnail" class="img-thumbnail"></a>
            </td>
            <td style="text-align:center;">{!! \App\Helpers\Helper::active($product->active) !!} </td>
            <td style="text-align:center;"><a href="{{ route('delatil_comment',['id'=>$product->id]) }}">Chi tiết</a></td>
            </tr>
        @endforeach
      </tbody>
    </table>
    {{-- Phan trang --}}
    {{ $products->links() }}
    
@endsection
