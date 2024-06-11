@extends('admin.main')


@section('content')
    <form action="" method="POST">
        <div class="card-body">
            <div class="form-group">
                <label for="name">Tên trang web</label>
                <input type="text" name="name" value="{{ $siteInfos->name}}" class="form-control" id="name">
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" name="address" value="{{ $siteInfos->address }}" class="form-control" id="address">
            </div>   
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" value="{{ $siteInfos->email }}" class="form-control" id="email">
            </div>
           
       
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
        </div>
        @csrf
    </form>
@endsection
