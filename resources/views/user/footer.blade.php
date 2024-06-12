<!-- Footer -->
<footer class="footer bg-dark text-white mt-4">
    <div class="container">
        <div class="row text-center">
            @if ($footers->isNotEmpty())
                @foreach ($footers as $footer)
                    <div class="col-lg-3 col-md-6">
                       <a href="#" target="_blank">
                        <h5 style="color: rgb(255, 255, 255)" class="mb-3">{{ $footer->name }}</h5></a> 
                    </div>
                @endforeach
            @else
                <div class="col">
                    <p>No footer content available.</p>
                </div>
            @endif
        </div>
    </div>

    <div style="margin-top: 20px" class="row contact-info">
        <div class="col-12 text-center">
            <p>Địa chỉ: Số 123, Đường ABC, Quận XYZ, Thành phố</p>
            <p>Điện thoại: 0123-456-789</p>
        </div>
    </div>
</footer>

<script rel="stylesheet" src="/template/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
<script rel="stylesheet" src="/template/js/public.js"></script>
</body>

</html>
@yield('user.footer')
