@extends('admin.main')
@section('content')
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Tiêu đề</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="name" required>
            </div>
            <div class="form-group">
                <label for="name">Đường dẫn</label>
                <input type="text" name="url" value="{{ old('url') }}" class="form-control" id="name" required>
            </div>
            <div class="form-group">
                <label for="price">Sắp xếp</label>
                <input type="number" name="sort_by" value="1" class="form-control" id="price" min="0" required>
            </div>

            <div class="form-group">
                <label for="">Ảnh Slider</label><br>
                <input type="file" name="file_img" id="upload" class="form-control" required>
                <div id="image_show">

                </div>
                <input type="hidden" name="thumb" id="thumb">
            </div>
            <div class="form-group">
                <label for="">Kích hoạt</label>
                <div class="d-flex">
                    <div class="custom-control custom-radio mr-5">
                        <input class="custom-control-input" type="radio" id="active" name="active" value="1"
                            checked>
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
            <button type="submit" class="btn btn-primary">Tạo sản phẩm</button>
        </div>
        @csrf
    </form>
@endsection
@section('footer')
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
