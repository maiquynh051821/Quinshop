<!DOCTYPE html>
<html lang="en">
<head>
 @include('admin.head')
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center ">
      <div id="form-login" class="col-lg-4 border p-4 mt-5"> <!-- Thêm lớp border và p-4 để tạo viền và khoảng cách xung quanh form -->
        <h2 class="text-center mb-5">Login</h2>
        @include('admin.alert')
        <form action="/admin/users/login/store" method="post">
          <div class="mb-4 input-group">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
          </div>
          <div class="mb-3 input-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label mb-3" for="remember">Ghi nhớ đăng nhập</label>
          </div>
          <div class="text-center">
            <button type="submit" class=" btn btn-success btn-block mb-2"><i class="fas fa-sign-in-alt"></i> Đăng nhập</button>
          </div>
          @csrf
        </form>
        <div class="text-center">
          <p>- Hoặc -</p>
          <button type="button" class="btn btn-danger mb-3"><i class="fab fa-google"></i> Đăng nhập bằng Google+</button>
          <p><a href="#">Bạn quên mật khẩu?</a></p>
          <p>Bạn chưa có tài khoản? <a href="#">Đăng ký</a></p>
        </div>
      </div>
    </div>
  </div>
@include('admin.footer')
</body>
</html>
