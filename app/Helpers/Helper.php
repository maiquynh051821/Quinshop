<?php

namespace App\Helpers;

class Helper
{
    public static function menu($menus, $parent_id = 0, $char = '')
    {
        $html = '';
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id == $parent_id) {
                $html .= '
                <tr>
                <th>' . $menu->id . '</th>
                <th>' . $char . $menu->name . '</th>
                <th>' . $menu->active . '</th>
                <th>' . $menu->updated_at . '</th>
                <th> <a class="btn btn-info" href="/admin/menus/edit/' . $menu->id . '"><i class="fa-regular fa-pen-to-square"></i></a> </th>
                <th> <a class="btn btn-danger" href="#" onclick="removeRow(' . $menu->id . ',\'/admin/menus/destroy\')"><i class="fa-solid fa-trash-can"></i></a> </th>
                </tr>
                ';
                unset($menus[$key]);
                $html .= self::menu($menus,$menu->id,$char . ' |--> ');
            }
        }
        return $html;
    }
}
