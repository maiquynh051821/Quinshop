@extends('admin.main')

@section('content')
    <div class="container mt-4">
        <h2>Chi tiết liên hệ</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Thông tin liên hệ</h5> <br><br>
                <p><strong>Email:</strong> {{ $contact->email }}</p>
                <p><strong>Nội dung:</strong></p>
                <p>{!! $contact->message !!}</p>
                <p><strong>Ngày gửi:</strong> {{ $contact->created_at }}</p>
                <p><strong>Trạng thái:</strong> 
                    @if ($contact->status == 0)
                        Chưa trả lời
                    @else
                        Đã trả lời
                    @endif
                </p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Trả lời liên hệ</h5> <br><br>
                <form action="{{ route('admin.contacts.sendReply', $contact->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="reply_email">Email người nhận:</label>
                        <input value="{{$contact->email}}" type="email" name="reply_email" id="reply_email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="reply_message">Nội dung trả lời:</label>
                        <textarea name="reply_message" id="reply_message" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi mail trả lời</button>
                </form>
            </div>
        </div>
        <a style="margin-bottom:30px" href="{{ route('admin.contacts.list') }}" class="btn btn-primary mt-3">Quay lại danh sách liên hệ</a>
    </div>
    
@endsection
