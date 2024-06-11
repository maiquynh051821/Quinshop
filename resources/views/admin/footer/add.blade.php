@extends('admin.main')

@section('head')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
@endsection

@section('content')

<form action="" method="POST">
    <div class="card-body">
      <div class="form-group">
        <label for="name">Tên danh mục footer</label>
        <input type="text" name="name" class="form-control" id="name" placeholder="Nhập tên danh mục">
      </div>
      <div class="form-group">
        <label for="content">Nội dung</label>
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
      <button type="submit" class="btn btn-primary">Tạo footer</button>
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


