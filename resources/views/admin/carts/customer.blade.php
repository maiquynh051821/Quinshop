<?php
use App\Http\Controllers\Admin\CartController;
?>
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
          <th style="width: 30px;text-align:center;">STT</th>
          <th style="text-align:center;">Tên Khách hàng </th>
          <th style="text-align:center;">Số Điện Thoại</th>
          {{-- <th style="width: 200px;text-align:center;">Email</th> --}}
          <th style="width: 200px;text-align:center;">Địa chỉ</th>
          <th style="width: 200px;text-align:center;">Hình thức TT</th>
          <th style="width: 200px;text-align:center;">Ngày đặt hàng</th>
          <th>Trạng thái đơn hàng</th>
          {{-- <th style="text-align:center;width: 250px;">Ảnh</th>
          <th style="text-align:center;">Active</th>
          <th style="width: 250px;text-align:center;">Update</th>
          <th style="width:25px">Delete</th> --}}
          <th style="width:25px">View</th>
        </tr>
      </thead>
      <tbody>
       
        @foreach ($customers as $key => $customer)
        @php
        $pay_method = $customer->pay_method == 1 ? 'Tiền mặt' : "TT Online"
    @endphp
        <tr>
            <td style="text-align:center;">{{$loop->iteration}}</td>
            <td style="padding-left:20px">{{$customer->name}}</td>
            <td style="padding-left:20px">{{$customer->phone}}</td>
            {{-- <td style="text-align:center">{{$customer->email }}</td> --}}
            <td style="text-align:center">{{$customer->address }}</td>
            <td style="text-align:center">{{$pay_method }}</td>
            <td style="text-align:center">{{$customer->created_at}}</td>
            <?php
            $statusCart = CartController::checkStatusCart($customer->id);
            ?>
            <td style="text-align:center">
              {{ $statusCart }}
            </td>
            <td> 
            <a class="btn btn-info" href="/admin/customers/view/{{$customer->id}}">
            <i class="fas fa-eye"></i>
            </a>
            </td>
           
            {{-- <td> 
            <a class="btn btn-danger" href="#" onclick="removeRow({{$cart->id}},'/admin/products/destroy')">
            <i class="fa-solid fa-trash-can"></i>
            </a> 
            </td> --}}
            </tr>
        @endforeach
      </tbody>
    </table>

    {{-- Phan trang --}}
    {{ $customers->links() }}
    
@endsection
