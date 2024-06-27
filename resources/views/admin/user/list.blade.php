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
  <form action="{{ route('search_user') }}" method="get">
    <div class="others">
        <input name="name_user" placeholder="Tìm kiếm" type="text">
        <button type="submit"><i class="fas fa-search" aria-hidden="true"></i></button>
    </div>
</form>
</div>
    <table class="table">
      <thead>
        <tr>
          <th style="width: 70px;text-align:center;">STT</th>
          <th style="width: 450px;text-align:center;">Tên</th>
          <th style="width: 450px;text-align:center;">Email</th>
          <th style="text-align:center;width: 250px;">Quyền</th>
          <th style="text-align:center;">Active</th>
          <th style="width: 250px;text-align:center;">Ngày tạo</th>
          <th style="width:25px">Edit</th>
          <th style="width:25px">Delete</th>
        </tr>
      </thead>
      <tbody>
        @if ($users)
        @foreach ($users as $key => $user)
        <tr>
            <td style="text-align:center;">{{$loop->iteration}}</td>
            <td style="padding-left:20px">{{$user->name}}</td>
            <td style="padding-left:20px">{{$user->email}}</td>
            <td style="padding-left:20px">{{$user->role}}</td>
            <td style="text-align:center;">{!! \App\Helpers\Helper::active($user->active) !!} </td>
            <td style="text-align:center;">{{$user->created_at}}</td>
            <td> 
            <a class="btn btn-info" href="/admin/users/edit/{{$user->id}}">
            <i class="fa-regular fa-pen-to-square"></i>
            </a>
            </td>
            <td> 
            <a class="btn btn-danger" href="#" onclick="removeRow({{$user->id}},'/admin/users/destroy')">
            <i class="fa-solid fa-trash-can"></i>
            </a> 
            </td>
            </tr>
        @endforeach
        @else 
        <h3>Không có người dùng nào được tìm thấy. </h3>
        @endif
       
      </tbody>
    </table>
    {{-- Phan trang --}}
    {{-- {{ $users->links() }} --}}

    
@endsection
