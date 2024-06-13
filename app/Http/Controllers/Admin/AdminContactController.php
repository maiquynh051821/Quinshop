<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReplyContactMail;
class AdminContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::paginate(5);
        return view('admin.contacts.list', compact('contacts'), [
            'title' => 'Danh sách thông tin liên hệ'
        ]);
    }
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.show', compact('contact'),
    [
        'title' => 'Chi tiết liên hệ'
    ]);
    }
    public function updateStatus(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->status = $request->status;
        $contact->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
    #Gui mail lien he
    public function sendReply(Request $request, $id)
    {
        $request->validate([
            'reply_email' => 'required|email',
            'reply_message' => 'required|min:10',
        ]);

        $contact = Contact::findOrFail($id);

        // Gửi email phản hồi
        Mail::to($request->reply_email)->send(new ReplyContactMail($request->reply_message));

        // Cập nhật trạng thái đã trả lời của liên hệ
        $contact->update([
            'status' => 1, // Đã trả lời
        ]);

        return redirect()->route('admin.contacts.show', $id)->with('success', 'Email phản hồi đã được gửi thành công và cập nhật trạng thái.');
    }
}