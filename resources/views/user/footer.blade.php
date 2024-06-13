<!-- Footer -->
<footer class="footer bg-dark text-white mt-4">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6">
                <a href="#" target="_blank">
                 <h5 style="color: rgb(255, 255, 255)" class="mb-3">Liên hệ</h5></a> 
             </div>
            @if ($footers->isNotEmpty())
                @foreach ($footers as $footer)
                    <div class="col-lg-3 col-md-6">
                       <a href="{{ route('footers.show', $footer->id) }}" target="_blank">
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

<div style="margin-top: 20px" class="text-center contact-info">
        @foreach ($infoSites as $infoSite)
        <p>Số điện thoại: {{$infoSite->phone}}</p>
        <p>Email: {{$infoSite->email}}</p>
        <p>Địa chỉ: {{$infoSite->address}}</p>
    @endforeach
    </div>
</footer>

<script rel="stylesheet" src="/template/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
<script rel="stylesheet" src="/template/js/public.js"></script>
</body>

</html>
@yield('user.footer')
