<?php

namespace App\Http\Services\Menu;

use Illuminate\Support\Str;
use App\Models\Admin\Menu;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
class UploadService
{
    public function store($request)
    {
       if($request->hasFile('file')){
        try{
            $uploadedFile = $request->file('file');
            $name = $uploadedFile->getClientOriginalName();  
            $pathFull = 'uploads/' .date("Y/m/d");
            // Lưu trữ file vào thư mục uploads trong storage/app/public
            $path = $uploadedFile->storeAs(
                'public/' .$pathFull , $name
            ); 
            return '/storage/' . $pathFull. '/' . $name;
        }catch(\Exception $error){
            return false;
        }
       } 
    }
}