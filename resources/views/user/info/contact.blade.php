@extends('user.main')
@section('user.header')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
@endsection

@section('body')

    <section style="margin-top:70px;min-height:700px">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h3 style="text-align:center;color:black ">Liên hệ</h3>

        <div class="container">
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="message">Nội dung liên hệ:</label>
                    <textarea name="message" class="form-control" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Gửi</button>
            </form>
        </div>

    </section>
    @if (session()->has('success'))
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".alert-success").fadeOut("slow");
                }, 5000); // Thay đổi bằng số miligiây bạn muốn thông báo hiển thị
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".alert-danger").fadeOut("slow");
                }, 5000); // Thời gian hiển thị là 5 giây (5000 miligiây)
            });
        </script>
    @endif
    <script>
        CKEDITOR.replace('message');
     </script>
@endsection
