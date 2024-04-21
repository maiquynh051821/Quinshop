<?php

namespace App\Helpers;

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
                <td style="text-align:center;">' . $menu->active . '</td>
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
                $html .= self::menu($menus,$menu->id,$char . ' |--> ');
            }
        }
        return $html;
    }
}
