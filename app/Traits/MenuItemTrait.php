<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

trait MenuItemTrait
{
    private $menuItem = [];
    private $results = [];

    public function getMenuItem()
    {
        $roleIds = Auth::user()->roles->map(function ($item) {
            return $item->id;
        })->toArray();
        dump($roleIds);

        $data = DB::table('permission_groups')
            ->select('id', 'parent_id', 'name', 'icon', 'route', DB::raw("
        (SELECT permissions.name
        FROM permission_role
        JOIN permissions ON permissions.id = permission_role.permission_id
        WHERE permission_role.role_id IN (" . implode(',', $roleIds) . ")
        AND permissions.name LIKE \"show-%\"
        AND permissions.permission_group_id = permission_groups.id) as have_permission"), DB::raw("(SELECT GROUP_CONCAT(id) FROM permission_groups as child_permission_groups WHERE child_permission_groups.parent_id = permission_groups.id) as child_item"))
            ->where('status', 'ACTIVE')
            ->orderBy('id', 'DESC')
            ->get();
        dd($data);

        $data = $data->map(function ($item) {
            $item->child_item = !is_null($item->child_item) ? array_map('intval', explode(',', $item->child_item)) : [];
            $item->have_permission = !is_null($item->have_permission) ? true : false;
            return $item;
        });

        $this->menuItem = json_decode(json_encode($data), true);

        return $this->menus();
    }

    // Generate Menus for User Permission through single role id
    private function menus()
    {
        $this->menuItem = array_map(function ($menu) {
            $menu['menus'] = !is_null($menu['child_item']) ? $this->margeChild(array_map('intval', $menu['child_item'])) : [];
            return $menu;
        }, $this->menuItem);

        foreach ($this->menuItem as $m => $menu) :
            if (count($menu['menus']) >= 1) :
                foreach ($menu['menus'] as $i => $item) :
                    if (count($item['child_item']) >= 1 && !array_key_exists('menus', $item)) :
                        $this->menuItem[$m]['menus'][$i]['menus'] = !is_null($item['child_item']) ? $this->margeChild(array_map('intval', $item['child_item'])) : [];
                    endif;
                endforeach;
            endif;
        endforeach;

        return $this->arrayLoopThrough();
    }

    //  Looping Menu items for User Permission through single role id
    private function arrayLoopThrough()
    {
        $data = array_filter($this->menuItem, function ($item) {
            if (is_null($item['parent_id'])) :
                return $item;
            endif;
        });

        $this->results = array_values($data);
        array_multisort($this->results);
        return $this->results;
    }

    private function margeChild($items)
    {
        $data = array_filter($this->menuItem, function ($item) use ($items) {
            if (in_array($item['id'], $items)) :
                return $item;
            endif;
        });

        return array_values($data);
    }
}
