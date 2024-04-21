@extends('admin.main')
@section('content')
<style>
  .table th:first-child {
      padding-left: 30px;
      padding-right: 80px;
  }
 
</style>
    <table class="table">
      <thead>
        <tr>
          <th style="width: 70px">ID</th>
          <th style="width: 1200px">Name</th>
          <th>Active</th>
          <th style="width: 250px">Update</th>
          <th style="width:50px">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        {{-- Sử dụng !! !! để có thể đọc được Html  --}}
        {!!\App\Helpers\Helper::menu($menus)!!}
      </tbody>
    </table>
@endsection
