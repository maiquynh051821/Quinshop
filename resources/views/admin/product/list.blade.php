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
          <th style="width: 450px;text-align:center;">Tên Sản Phẩm </th>
          <th style="width: 450px;text-align:center;">Danh Mục </th>
          <th style="width: 200px;text-align:center;">Giá Gốc</th>
          <th style="width: 200px;text-align:center;">Giá Sale</th>
          <th style="text-align:center;width: 250px;">Ảnh</th>
          <th style="text-align:center;">Active</th>
          <th style="width: 250px;text-align:center;">Update</th>
          <th style="width:25px">Edit</th>
          <th style="width:25px">Delete</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $key => $product)
        <tr>
            <td style="text-align:center;">{{$loop->iteration}}</td>
            <td style="padding-left:20px">{{$product->name}}</td>
            <td style="padding-left:20px">{{optional($product->menu)->name}}</td>
            <td style="text-align:center">{{ number_format($product->price, 0, ',', '.') }} ₫</td>
            <td style="text-align:center">{{ number_format($product->price_sale, 0, ',', '.') }} ₫</td>
            <td style="text-align:center"><a href="{{ $product->thumb }}">
              <img src="{{ $product->thumb }}" alt="Thumbnail" class="img-thumbnail"></a>
            </td>
            <td style="text-align:center;">{!! \App\Helpers\Helper::active($product->active) !!} </td>
            <td style="text-align:center;">{{$product->updated_at}}</td>
            <td> 
            <a class="btn btn-info" href="/admin/products/edit/{{$product->id}}">
            <i class="fa-regular fa-pen-to-square"></i>
            </a>
            </td>
            <td> 
            <a class="btn btn-danger" href="#" onclick="removeRow({{$product->id}},'/admin/products/destroy')">
            <i class="fa-solid fa-trash-can"></i>
            </a> 
            </td>
            </tr>
        @endforeach
      </tbody>
    </table>
    {{-- Phan trang --}}
    {{ $products->links() }}
    
@endsection
