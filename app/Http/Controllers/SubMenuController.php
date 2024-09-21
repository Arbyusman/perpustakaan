<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubMenuRequest;
use App\Http\Requests\UpdateSubMenuRequest;
use App\Models\SubMenu;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class SubMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($menuId)
    {
        $id = crypt::decrypt($menuId);
        $menu = Menu::findOrFail($id);
        $title = "Sub Menu";
        $description = "SubMenu dari menu" . $menu->manu_name;
        $subMenus = SubMenu::where('menu_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.sub-menu.index', compact('title', 'subMenus', 'description', 'menu'));
    }


    public function create($menuId)
    {
        $id = crypt::decrypt($menuId);
        $menu = Menu::findOrFail($id);
        $title = "Tambah Sub Menu";
        $view = view('admin.sub-menu.create', compact('title', 'menu'));
        $view = $view->render();
        return $view;
    }

    public function store(Request $request, $menuId)
    {
        $id = crypt::decrypt($menuId);
        $validator = Validator::make($request->all(), [
            'sub_menu_name' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'attribute' => 'string|max:255',
            'category' => 'string|max:20',
            'position' => 'required|string|max:100',
            'description' => 'string|max:100',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return redirect()->back();
        }

        $input = [
            'menu_id' => $id,
            'name' => $request->sub_menu_name,
            'attribute' => $request->attribute,
            'link' => $request->link,
            'position' => $request->position,
            'description' => $request->description,
            'category' => $request->category,
        ];

        SubMenu::create($input);
        Alert::toast('Sub Menu Berhasil Ditambah', 'success');
        return redirect('admin/submenus/' . $menuId);
    }

    public function edit(SubMenu $submenu, $menu, $submenuId)
    {
        $id = crypt::decrypt($menu);
        $menu = Menu::findOrFail($id);
        $idSub = crypt::decrypt($submenuId);
        $submenu = SubMenu::findOrFail($idSub);
        $title = "Edit Sub Menu";
        $view = view('admin.sub-menu.edit', compact('title',  'menu', 'submenu'));
        $view = $view->render();
        return $view;
    }

    public function update(Request $request, $menuId, $submenuId)
    {

        $id = Crypt::decrypt($menuId);
        $idMenu = Menu::findOrFail($id);

        $submenuid = crypt::decrypt($submenuId);
        $submenu = SubMenu::findOrFail($submenuid);

        $validator = Validator::make($request->all(), [
            'sub_menu_name' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'attribute' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return redirect()->back();
        }

        $input = [
            'name' => $request->sub_menu_name,
            'attribute' => $request->attribute,
            'link' => $request->link,
            'position' => $request->position,
            'description' => $request->description,
            'category' => $request->category,
        ];

        $submenu->update($input);
        Alert::toast('Sub Menu Berhasil DiUbah', 'success');
        return redirect('admin/submenus/' . $menuId);
    }

    public function destroy(Request $request, $menuId)
    {
        $id = Crypt::decrypt($request->id);
        $menu = SubMenu::findOrFail($id);
        $menu->delete();
        Alert::toast('Sub Menu Berhasil DiHapus', 'success');
        return redirect('admin/submenus/' . $menuId);
    }
}
