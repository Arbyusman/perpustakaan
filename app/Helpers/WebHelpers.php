<?php

namespace App\Helpers;

use App\Models\MenuAccess;
use App\Models\Setting;
use App\Models\SubMenuAccess;
use Illuminate\Support\Facades\Auth;

class WebHelpers
{
    public static function settingMenu()
    {
        $menu = MenuAccess::leftJoin('roles', 'menu_accesses.role_id', '=', 'roles.id')
            ->leftJoin('menus', 'menu_accesses.menu_id', '=', 'menus.id')
            ->where('menu_accesses.role_id', Auth::user()->role_id)
            ->where('menus.category', 1)
            ->orderBy('menus.position', 'ASC')
            ->get();
        return $menu;
    }

    public static function mainMenu()
    {
        $menu = MenuAccess::leftJoin('roles', 'menu_accesses.role_id', '=', 'roles.id')
            ->leftJoin('menus', 'menu_accesses.menu_id', '=', 'menus.id')
            ->where('menu_accesses.role_id', Auth::user()->role_id)
            ->where('menus.category', 2)
            ->orderBy('menus.position', 'ASC')
            ->get();
        return $menu;
    }

    public static function masterDataMenu()
    {
        $menu = MenuAccess::leftJoin('roles', 'menu_accesses.role_id', '=', 'roles.id')
            ->leftJoin('menus', 'menu_accesses.menu_id', '=', 'menus.id')
            ->where('menu_accesses.role_id', Auth::user()->role_id)
            ->where('menus.category', 3)
            ->orderBy('menus.position', 'ASC')
            ->get();
        return $menu;
    }

    public static function submenu($menu_id)
    {
        $submenu = SubMenuAccess::leftJoin('roles', 'sub_menu_accesses.role_id', '=', 'roles.id')
            ->leftJoin('sub_menus', 'sub_menu_accesses.sub_menu_id', '=', 'sub_menus.id')
            ->where('sub_menu_accesses.role_id', Auth::user()->role_id)
            ->where('sub_menus.menu_id', $menu_id)
            ->orderBy('position', 'ASC')->get();
        return $submenu;
    }

    public static function setting()
    {
        $setting = Setting::first();
        return $setting;
    }
}
