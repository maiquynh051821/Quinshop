<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
class AdminContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::paginate(5);
        return view('admin.contacts.list', compact('contacts'),[
            'title' => 'Danh sách thông tin liên hệ'
        ]);
    }
}