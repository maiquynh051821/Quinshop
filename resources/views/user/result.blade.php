@extends('user.main')
@section('body')
    <h3 style="margin:70px 20px 30px ">Kết quả tìm kiếm của từ khóa: "{{$query}}"</h3>
    @if ($products->isEmpty())
        <h5 style="margin:25px 30px 700px">Không tìm thấy sản phẩm nào</h5>
    @else
    <div id="loadProduct" style="min-height: 700px">
        @include('user.products.list')   
    </div>
    @endif
@endsection