<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use PhpParser\Node\Stmt\Return_;

class Helper
{
    // Tao HTML cho menu tu 1 mang cac menu duoc  cung cap
    public static function menu($menus, $parent_id = 0, $char = '', $parent_stt = '', $stt = 1)
    {
        $html = '';
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id == $parent_id) {
                // Lấy số thứ tự hiện tại
                $current_stt = $parent_stt ? $parent_stt . '.' . $stt : $stt;

                $html .= '
                <tr>
                <td style="text-align:center;">' . $current_stt . '</td>
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

                // Xóa phần tử đã xử lý
                unset($menus[$key]);

                // Gọi đệ quy cho các danh mục con với số thứ tự mới
                $html .= self::menu($menus, $menu->id, $char . ' |--> ', $current_stt, $sub_stt = 1);

                // Tăng số thứ tự của mục hiện tại
                $stt++;
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
    public static function menus($menus, $parent_id = 0): string
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
                if (self::isChild($menus, $menu->id)) {
                    $html .= '<ul class="sub-menu">';
                    $html .= self::menus($menus, $menu->id);
                    $html .= '</ul>';
                }
                $html .= '</li>';
            }
        }
        return $html;
    }
    #Kiem tra danh muc cha co danh muc con khong
    public static function isChild($menus, $id): bool
    {
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id == $id) {
                return true;
            }
        }
        return false;
    }
    public static function price($price = 0, $priceSale = 0)
    {
        if ($priceSale != 0) return number_format($priceSale);
        if ($price != 0) return number_format($price);
        return '<a target="_blank" href="/contact">Liên hệ</a>';
    }
}
