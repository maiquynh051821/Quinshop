<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="/template/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8e0e6;
            /* Màu hồng nhạt */
        }

        /* Tùy chỉnh để căn lề phải của biểu tượng */
        .input-group .input-group-text {
            border-radius: .25rem 0 0 .25rem;
        }

        #form-login {
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center ">
            <div id="form-login" class="border border-success rounded-2 col-lg-4 border p-4 mt-5">
                <!-- Thêm lớp border và p-4 để tạo viền và khoảng cách xung quanh form -->
                <h2 class="text-center mb-3">Quên mật khẩu</h2>
                <div id="error-message" class="mb-3"></div>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form id="reset_password" action="{{ route('reset_password') }}" method="get">
                    <input type="hidden" name="userName" value="{{ $userName }}">
                    <div class="mb-3 input-group">
                        <input type="text" class="form-control" id="code" name="code"
                            placeholder="Nhập mã code" required>
                        <span class="input-group-text"><i class="fas fa-envelope" style="color:blue"></i></span>
                    </div>

                    <div class="mb-3 input-group">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Nhập mật khẩu mới" required>
                        <span class="input-group-text"><i class="fas fa-lock" style="color:red"></i></span>
                    </div>

                    <div class="mb-3 input-group">
                        <input type="password" class="form-control" id="resetpassword" name="resetpassword"
                            placeholder="Nhập lại mật khẩu" required>
                        <span class="input-group-text"><i class="fas fa-lock" style="color:red"></i></span>
                    </div>
                    <div class="text-center">
                        <button type="submit" class=" btn btn-success btn-block mb-2"><i
                                class="fas fa-sign-in-alt"></i> Thay đổi mật khẩu</button>
                    </div>
                    @csrf
                </form>
                <div class="text-center">
                    <p>Quay lại trang <a href="/login"> Đăng nhập</a></p>
                    <p><a href="/">Quay về trang chủ</a></p>
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
                    }, 3000);
                });
            </script>
        @endif

    </div>

    <script>
        document.getElementById('reset_password').addEventListener('submit', function(event) {
            event.preventDefault();
            const codeInput = document.getElementById('code').value;
            const password = document.getElementById('password').value;
            const resetpassword = document.getElementById('resetpassword').value;
            const sessionCode = '{{ session('code') }}';
            const errorMessageElement = document.getElementById('error-message');
            errorMessageElement.innerHTML = '';
            console.log(sessionCode);
            if (codeInput !== sessionCode) {
                errorMessageElement.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Mã code không đúng!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
                return;
            }
            if (password !== resetpassword) {
                errorMessageElement.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Mật khẩu không khớp!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
                return;
            }
            event.target.submit();
        });
    </script>
</body>

</html>
