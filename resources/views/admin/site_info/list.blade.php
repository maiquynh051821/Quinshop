@extends('admin.main')
@section('content')
    <style>
        table {
            border-collapse: collapse;
            /* Kết hợp đường viền giữa các ô */
            width: 100%;
            /* Đảm bảo bảng chiếm toàn bộ chiều rộng */
        }

        th,
        td {
            border: 1px solid rgb(252, 207, 207);
            /* Đặt đường viền 1px đen cho các ô */
            padding: 8px;
        }
    </style>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 70px;text-align:center;">STT</th>
                <th style="width: 450px;text-align:center;">Tên</th>
                <th style="text-align:center;width: 250px;">Địa chỉ</th>
                <th style="text-align:center;width: 250px;">Số điện thoại</th>
                <th style="width: 450px;text-align:center;">Email</th>
                <th style="width: 250px;text-align:center;">Ngày cập nhật</th>
                <th style="width:25px">Edit</th>
            </tr>
        </thead>
        <tbody>
            @if ($siteInfo)
                @foreach ($siteInfo as $item)
                    <tr>
                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                        <td style="padding-left:20px">{{ $item->name }}</td>
                        <td style="padding-left:20px">{{ $item->address }}</td>
                        <td style="padding-left:20px">{{ $item->phone }}</td>
                        <td style="padding-left:20px">{{ $item->email }}</td>
                        <td style="text-align:center;">{{ $item->updated_at }}</td>
                        <td>
                            <a class="btn btn-info" href="/admin/siteInfos/edit/{{ $item->id }}">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <h5>Thông tin trống</h5>
            @endif



        </tbody>
    </table>
    {{-- Phan trang --}}
    {{-- {{ $users->links() }} --}}


@endsection
