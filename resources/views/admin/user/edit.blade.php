@extends('admin.main')


@section('content')
    <form action="" method="POST">
        <div class="card-body">
            <div class="form-group">
                <label for="name">Tên khách hàng</label>
                <input type="text" name="name" value="{{ $user->name}}" class="form-control" id="name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" value="{{ $user->email }}" class="form-control" id="email">
            </div>
            <div class="form-group">
                <label for="role">Phân quyền</label>
                <select name="role" id="role" class="form-control">
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>   
            <div class="form-group">
                <label for="">Kích hoạt</label>
                <div class="d-flex">
                    <div class="custom-control custom-radio mr-5">
                        <input class="custom-control-input" type="radio" id="active" name="active" value="1"
                            {{$user->active == 1 ? 'checked' : ''}}>
                        <label for="active" class="custom-control-label">Có</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="no_active" name="active" value="0"
                        {{$user->active == 0 ? 'checked' : ''}}>
                        <label for="no_active" class="custom-control-label">Không</label>
                    </div>
                </div>
            </div>
        @if ($user->google_id == NULL)
        <div class="form-group">
            <label for="password">Mật khẩu mới</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="password_confirmation">Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
        @else
            <b>Mật khẩu</b>
            <p style="color:red">* Tài khoản này đăng nhập bằng google nên không cần mật khẩu</p>
        @endif
            
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập nhật tài khoản</button>
        </div>
        @csrf
    </form>
@endsection
