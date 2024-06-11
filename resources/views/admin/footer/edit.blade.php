@extends('admin.main')

@section('head')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
@endsection

@section('content')

<form action="" method="POST">
    <div class="card-body">
      <div class="form-group">
        <label for="menu">Tên danh mục footer</label>
        <input type="text" name="name" value="{{$footer->name}}" class="form-control" id="menu" placeholder="Nhập tên danh mục">
      </div>
      <div class="form-group">
        <label for="menu">Nội dung</label>
        <textarea name="content" id="content" class="form-control">{{$footer->content}}</textarea>
      </div>
      <div class="form-group">
        <label for="">Kích hoạt</label>
        <div class="d-flex">
            <div class="custom-control custom-radio mr-5">
                <input class="custom-control-input" type="radio" id="active" name="active" value="1" 
                {{$footer->active == 1 ? 'checked=""' : ''}}> 
                <label for="active" class="custom-control-label">Có</label>
            </div>
            <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" id="no_active" name="active" value="0"
                {{$footer->active == 0 ? 'checked=""' : ''}}>
                <label for="no_active" class="custom-control-label">Không</label>
            </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Cập nhật danh mục footer</button>
    </div>
    @csrf
  </form>
@endsection

@section('footer')
{{-- Tạo ckeditor cho mục mô tả chi tiết --}}
<script>
    CKEDITOR.replace('content');
</script>
@endsection


