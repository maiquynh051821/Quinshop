@extends('admin.main')
@section('content')
<style>

  table {
        border-collapse: collapse; /* Kết hợp đường viền giữa các ô */
        width: 100%; /* Đảm bảo bảng chiếm toàn bộ chiều rộng */
    }
    th, td {
        border: 1px solid rgb(252, 207, 207); /* Đặt đường viền 1px đen cho các ô */
        padding: 8px;
    }
 
</style>
    <table class="table">
      <thead>
        <tr>
          <th style="width: 70px;text-align:center;">STT</th>
          <th style="width: 350px;text-align:center;">Bình luận</th>
          <th style="width: 350px;text-align:center;">Số sao</th>
          <th style="text-align:center;">Active</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($comments as $key => $comment)
        <tr>
            <td style="text-align:center;">{{$key + 1}}</td>
            <td style="padding-left:20px">{{$comment->COMMENT}}</td>
            <td style="padding-left:20px">{{ $comment->star }}</td>
            <td style="text-align:center">
                @if( $comment->STATUS == 1)
                <a style="background: #08a300 ; color: #fff ; padding: 3px 15px ; border-radius:8px " href="{{ route('edit_comment',['id'=>$comment->id]) }}">Mở</a>
                @else
                <a style="background: red; color: #fff ; padding: 3px 15px ; border-radius:8px "  href="{{ route('edit_comment',['id'=>$comment->id]) }}">Đóng</a>
                @endif
               
            </td>

            </tr>
        @endforeach
      </tbody>
    </table>
@endsection
