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
  <form action="{{ route('search_product') }}" method="get">
    <div class="others">
        <input name="name_product" placeholder="Tìm kiếm" type="text">
        <button type="submit"><i class="fas fa-search" aria-hidden="true"></i></button>
    </div>
</form>
</div>
    <table id="example" class="table">
      <thead>
        <tr>
          <th style="width: 70px;text-align:center;">STT</th>
          <th style="width: 450px;text-align:center;">Tên Sản Phẩm </th>
          <th style="width: 450px;text-align:center;">Danh Mục </th>
          <th style="width: 200px;text-align:center;">Giá Gốc</th>
          <th style="width: 200px;text-align:center;">Giá Sale</th>
          <th style="text-align:center;width: 200px;">Ảnh</th>
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
            <td style="text-align:center">
              @if ($product->price !== null)
              {{ number_format($product->price, 0, ',', '.') }} ₫
              @endif
            </td>
            <td style="text-align:center">
              @if ($product->price_sale !== null)
              {{ number_format($product->price_sale, 0, ',', '.') }} ₫ 
              @endif
            </td>
            <?php
                 $thumbs = json_decode($product->thumb);
                  $firstThumb = $thumbs[0] ?? null;   
                ?>
            <td style="text-align:center"><a>
              <img style="width: 70px;height:auto" src="{{ asset($firstThumb) }}" alt="Thumbnail" class="img-thumbnail"></a>
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
    <script>
      $(document).ready(function() {
          $('#example').DataTable({
              language: {
                  "decimal": "",
                  "emptyTable": "Không có dữ liệu trong bảng",
                  "info": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                  "infoEmpty": "Hiển thị 0 đến 0 của 0 mục",
                  "infoFiltered": "(lọc từ _MAX_ mục)",
                  "infoPostFix": "",
                  "thousands": ",",
                  "lengthMenu": "Hiển thị _MENU_ mục",
                  "loadingRecords": "Đang tải...",
                  "processing": "Đang xử lý...",
                  "search": "Tìm kiếm:",
                  "zeroRecords": "Không tìm thấy kết quả",
                  "paginate": {
                      "first": "Đầu tiên",
                      "last": "Cuối cùng",
                      "next": "Tiếp",
                      "previous": "Trước"
                  },
                  "aria": {
                      "sortAscending": ": sắp xếp cột tăng dần",
                      "sortDescending": ": sắp xếp cột giảm dần"
                  }
              }
          });
      });
  </script>
@endsection
