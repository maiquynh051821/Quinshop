<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\Footer\FooterService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Footer;

class FooterController extends Controller
{
    protected $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }



    public function index()
    {
        return view('admin.footer.list', [
            'title' => 'Danh sách Footer',
            'footers' =>  $this->footerService->getAll(),
        ]);
    }

    public function create()
    {
        return view('admin.footer.add', [
            'title' => 'Thêm Footer',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'content' => 'required',
            'active' => 'required'
        ]);

        $this->footerService->create($data);

        return redirect()->back();
    }
    public function show(Footer $footer)
    {
        return view('admin.footer.edit', [
            'title' => 'Chỉnh sửa Footer: ' . $footer->name,
            'footer' => $footer,
        ]);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'content' => 'required',
            'active' => 'required|boolean',
        ]);

        $this->footerService->update($id, $request->all());

        return redirect()->route('admin.footer.list');
    }
    public function destroy(Request $request)  //
    {
        $result = $this->footerService->delete($request);
        if($result){
            return response()->json([
                'error' => false,
                'message' => 'Xóa footer thành công',
            ]);
        }
        return response()->json(['error' => true]);
    }
    
}