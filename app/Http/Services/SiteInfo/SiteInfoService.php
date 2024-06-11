<?php

namespace App\Http\Services\SiteInfo;

use App\Models\Admin\SiteInfo;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
class SiteInfoService
{

    public function update($id, $data)
{
    try {
        $siteInfo = SiteInfo::findOrFail($id);
        $siteInfo->update($data);
        Session::flash('success', 'Cập nhật thông tin trang web thành công');
    } catch (\Exception $err) {
        Session::flash('error', 'Cập nhật thông tin trang web không thành công');
        Log::error($err->getMessage());
        return false;
    }
    return true;
}
}