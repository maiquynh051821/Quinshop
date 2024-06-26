<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Http\Services\SiteInfo\SiteInfoService;
use App\Models\Admin\SiteInfo;
class SiteInfoController extends Controller
{
    protected $siteInfoService;

    public function __construct(SiteInfoService $siteInfoService)
    {
        $this->siteInfoService = $siteInfoService;
    }
    public function index()
    {
        $siteInfo = SiteInfo::all();
        return view('admin.site_info.list', compact('siteInfo'),[
            'title' => 'Thông tin trang web'
        ]);
    }
    public function show(SiteInfo $siteInfo)
    {
        return view('admin.site_info.edit', [
            'title' => 'Chỉnh sửa SiteInfo: ' . $siteInfo->name,
            'siteInfos' => $siteInfo,
        ]);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'address'=> 'required',
            'phone'=>'required|numeric',
            'email' => 'required|email',
        ]);
    
        $this->siteInfoService->update($id, $request->all());
    
        return redirect()->route('admin.site_info.list');
    }


}