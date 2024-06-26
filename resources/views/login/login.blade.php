<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{$title}}</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="/template/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
  <!-- FontAwesome CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <style>
    body {
      background-color: #f8e0e6; /* Màu hồng nhạt */
    }
   
    /* Tùy chỉnh để căn lề phải của biểu tượng */
    .input-group .input-group-text {
      border-radius: .25rem 0 0 .25rem;
    }
    #form-login{
        background-color:  #ffffff; 
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center ">
      <div id="form-login" class="border border-success rounded-2 col-lg-4 border p-4 mt-5"> <!-- Thêm lớp border và p-4 để tạo viền và khoảng cách xung quanh form -->
        <h2 class="text-center mb-5">LOGIN</h2>
        @include('login.alert')
        <form action="/login/store" method="post">
          <div class="mb-4 input-group">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" @if (isset($_COOKIE["email"]))
                value={{$_COOKIE["email"]}}
            @endif required>
            <span class="input-group-text"><i class="fas fa-envelope" style="color:blue"></i></span>
          </div>
          <div class="mb-3 input-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password"  @if (isset($_COOKIE["password"]))
            value={{$_COOKIE["password"]}}
        @endif required>
            <span class="input-group-text"><i class="fas fa-lock" style="color:red"></i></span>
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember" @if (isset($_COOKIE["email"])) checked="" @endif>
            <label class="form-check-label mb-3" for="remember">Ghi nhớ đăng nhập</label>
          </div>
          <div class="text-center">
            <button type="submit" class=" btn btn-success btn-block mb-2"><i class="fas fa-sign-in-alt"></i> Đăng nhập</button>
          </div>
          @csrf
        </form>
        <div class="text-center">
          <p>- Hoặc -</p>
          <button type="button" class="btn mb-3" style=" background-image: linear-gradient(to right, #ff4e50, #f9d423);"> <a style="color:rgb(255, 255, 255); text-decoration: none;" 
            href="/login/google"><i class="fab fa-google" ></i> Đăng nhập bằng Google+</a></button>
          <p><a class="text-decoration-none text-primary fw-bold" href="{{ route('forget_password') }}">Bạn quên mật khẩu?</a></p>
          <p>Bạn chưa có tài khoản? <a href="/register" class="text-decoration-none text-primary fw-bold">Đăng ký</a></p>
          <p><a href="/" class="text-decoration-none text-secondary fw-bold">Quay về trang chủ</a></p>
        </div>
      </div>
    </div> 
  </div>
  <!-- Bootstrap Bundle with Popper -->
  <script rel="stylesheet" src="/template/bootstrap-5.3.3-dist/jsbootstrap.bundle.min.js"></script>
  <!-- FontAwesome JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
  <div class="container">
    @if (session()->has('success'))
    <script>
      $(document).ready(function() {
          setTimeout(function() {
              $(".alert-success").fadeOut("slow");
          }, 3000); // Thay đổi bằng số miligiây bạn muốn thông báo hiển thị
      });
      </script>
    @endif
    
  </div>
</body>
</html>
