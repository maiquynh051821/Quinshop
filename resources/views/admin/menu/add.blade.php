@extends('admin.main')

@section('header')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
@endsection

@section('content')
<form action="{{url('admin/menus/add')}}" method="POST">
    <div class="card-body">
      <div class="form-group">
        <label for="menu">Tên danh mục</label>
        <input type="text" name="name" class="form-control" id="menu" placeholder="Nhập tên danh mục">
      </div>
      <div class="form-group">
        <label>Danh mục</label>
        <select name="parent_id" id="" class="form-control">
            <option value="0">Danh mục cha</option>
            @foreach ($menus as $menu)
            <option value="{{$menu->id}}">{{$menu->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Mô tả ngắn</label>
        <textarea name="description" id="" class="form-control"></textarea>
      </div>
      <div class="form-group">
        <label for="menu">Mô tả chi tiết</label>
        <textarea name="content" id="content" class="form-control"></textarea>
      </div>
      <div class="form-group">
        <label for="">Kích hoạt</label>
        <div class="d-flex">
            <div class="custom-control custom-radio mr-5">
                <input class="custom-control-input" type="radio" id="active" name="active" value="1" checked> 
                <label for="active" class="custom-control-label">Có</label>
            </div>
            <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" id="no_active" name="active" value="0">
                <label for="no_active" class="custom-control-label">Không</label>
            </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Tạo danh mục</button>
    </div>
    @csrf
  </form>
@endsection

@section('footer')
{{-- Tạo ckeditor cho mục mô tả chi tiết --}}
<script>
    CKEDITOR.replace('content');
</script>
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


