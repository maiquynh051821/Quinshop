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
                <th style="width: 90px;text-align:center;">STT</th>
                <th style="width: 1200px;text-align:center;">Name</th>
                <th style="text-align:center;">Active</th>
                <th style="width: 250px;text-align:center;">Update</th>
                <th style="width:25px">Edit</th>
                <th style="width:25px">Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($footers as $key => $footer)
                <tr>
                    <td style="text-align:center;">{{ $loop->iteration }}</td>
                    <td style="padding-left:20px">{{ $footer->name }}</td>
                    <td style="text-align:center;">{!! \App\Helpers\Helper::active($footer->active) !!} </td>
                    <td style="text-align:center;">{{ $footer->updated_at }}</td>
                    <td>
                        <a class="btn btn-info" href="/admin/footers/edit/{{ $footer->id }}">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-danger" href="#"
                            onclick="removeRow({{ $footer->id }},'/admin/footers/destroy')">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>
                    </td>
                <tr>
            @endforeach
        </tbody>
    </table>
@endsection
