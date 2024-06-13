@extends('admin.main')

@section('content')
<div class="mr-4 ml-4 mb-4 mt-4">
    <h2>Danh sách liên hệ</h2>
    @if ($contacts->isEmpty())
        <p>Không có thông tin liên hệ nào.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Nội dung</th>
                    <th>Ngày gửi</th>
                    <th>Xem</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->id }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{!! substr($contact->message, 0, 150) !!}{!! strlen($contact->message) > 100 ? '...' : '' !!}</td>
                        <td>{{ $contact->created_at }}</td>
                        <td><a href="{{ route('contacts.show', $contact->id) }}" class="btn btn-info btn-sm">Xem chi tiết</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
{{ $contacts->links() }}
@endsection
