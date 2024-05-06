<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use PhpParser\Node\Stmt\Return_;

class Helper
{
    // Tao HTML cho menu tu 1 mang cac menu duoc  cung cap
    public static function menu($menus, $parent_id = 0, $char = '')
    {
        $html = '';
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id == $parent_id) {
                $html .= '
                <tr>
                <td style="text-align:center;">' . $menu->id . '</td>
                <td style="padding-left:20px">' . $char . $menu->name . '</td>
                <td style="text-align:center;">' . self::active($menu->active) . '</td>
                <td style="text-align:center;">' . $menu->updated_at . '</td>
                <td> 
                <a class="btn btn-info" href="/admin/menus/edit/' . $menu->id . '">
                <i class="fa-regular fa-pen-to-square"></i>
                </a>
                </td>
                <td> 
                <a class="btn btn-danger" href="#" onclick="removeRow(' . $menu->id . ',\'/admin/menus/destroy\')">
                <i class="fa-solid fa-trash-can"></i>
                </a> 
                </td>
                </tr>
                ';
                unset($menus[$key]);
                $html .= self::menu($menus, $menu->id, $char . ' |--> ');
            }
        }
        return $html;
    }
    public static function active($active = 0): string
    {
        return '<div class="col d-flex justify-content-center">
        <div class="rounded-circle ' . ($active == 0 ? 'bg-danger' : 'bg-success') .
            '" style="width: 20px; height: 20px;"></div></div>';
    }

    #Load danh muc ra trang chu
    public static function menus($menus, $parent_id = 0):string
    {
        $html = '';
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id == $parent_id) {
                $html .= '
            <li>
                <a href="/danh-muc/' . $menu->id . '-' . Str::slug($menu->name, '-') . '.html">
                ' . $menu->name . '
                </a>';
                unset($menus[$key]); // Xoa phan tu cua mang , muc dich loai bo cac danh muc da duoc xu ly ra khoi mang
                if(self::isChild($menus,$menu->id)){
                    $html .= '<ul class="sub-menu">';
                    $html .= self::menus($menus,$menu->id);
                    $html .= '</ul>';
                }
                $html .= '</li>';
            }
        }
        return $html;
    }
    #Kiem tra danh muc cha co danh muc con khong
    public static function isChild($menus, $id):bool
    {
        foreach($menus as $key => $menu){
            if($menu->parent_id == $id){
                return true;
            }  
        }
        return false;
    }
    public static function price($price = 0, $priceSale = 0)
    {
        if($priceSale != 0) return number_format($priceSale);
        if($price != 0) return number_format($price);
        return '<a href="/lien-he.html">Liên hệ</a>';
    }
}
