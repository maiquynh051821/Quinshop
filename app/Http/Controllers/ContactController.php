<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
class ContactController extends Controller
{
    public function show()
    {
        return view('user.info.contact',[
            'title'=> 'Liên hệ'
        ]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|min:10',
        ],[
            'message.min' => 'Nội dung liên hệ phải có ít nhất 10 ký tự.'
        ]);

        // Lưu thông tin liên hệ vào cơ sở dữ liệu
        $contact = Contact::create([
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return redirect()->route('contact.form')->with('success', 'Liên hệ của bạn đã được gửi thành công!');
    }
}