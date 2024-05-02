@extends('admin.main')


@section('content')
    <form action="" method="POST">
        <div class="card-body">
            <div class="form-group">
                <label for="name">Tiêu đề</label>
                <input type="text" name="name" value="{{ $slider->name}}" class="form-control" id="name">
            </div>
            <div class="form-group">
                <label for="name">Đường dẫn</label>
                <input type="text" name="url" value="{{ $slider->url }}" class="form-control" id="name">
            </div>
            <div class="form-group">
                <label for="price">Sắp xếp</label>
                <input type="number" name="sort_by" value="{{$slider->sort_by}}" class="form-control" id="price" min="0">
            </div>

            <div class="form-group">
                <label for="">Ảnh Slider</label><br>
                <input type="file" id="upload" class="form-control" multiple>
                <div id="image_show">
                    <a href="{{$slider->thumb}}">
                    <img src="{{$slider->thumb}}" alt="" width="100px">
                    </a>
                </div>
                <input type="hidden" name="thumb" id="thumb" value="{{$slider->thumb}}">
            </div>
            <div class="form-group">
                <label for="">Kích hoạt</label>
                <div class="d-flex">
                    <div class="custom-control custom-radio mr-5">
                        <input class="custom-control-input" type="radio" id="active" name="active" value="1"
                            {{$slider->active == 1 ? 'checked' : ''}}>
                        <label for="active" class="custom-control-label">Có</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="no_active" name="active" value="0"
                        {{$slider->active == 0 ? 'checked' : ''}}>
                        <label for="no_active" class="custom-control-label">Không</label>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập nhật Slider</button>
        </div>
        @csrf
    </form>
@endsection
