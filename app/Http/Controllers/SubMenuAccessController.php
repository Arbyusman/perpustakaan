<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubMenuAccessRequest;
use App\Http\Requests\UpdateSubMenuAccessRequest;
use App\Models\SubMenuAccess;
use App\Models\SubMenu;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class SubMenuAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($role_id, $menu_id)
    {
        $title = "Sub Menu Akses";

        $role_id = Crypt::decrypt($role_id);
        $menu_id = Crypt::decrypt($menu_id);
        $role = Role::findOrFail($role_id);
        $menu = Menu::findOrFail($menu_id);

        $sub_menu_access = SubMenuAccess::select('sub_menu_accesses.*', 'name')
            ->leftJoin('sub_menus', 'sub_menus.id', '=', 'sub_menu_accesses.sub_menu_id')
            ->where('role_id', $role_id)
            ->where('sub_menu_accesses.menu_id', $menu_id)
            ->orderBy('position', 'ASC')->get();
        return view('admin.sub-menu-akses.index', compact('title', 'role', 'menu', 'sub_menu_access'));
    }


    public function create($role_id, $menu_id)
    {
        $title = "Sub Menu Akses";

        $role_id = Crypt::decrypt($role_id);
        $menu_id = Crypt::decrypt($menu_id);

        $role = Role::findOrFail($role_id);
        $menu = Menu::findOrFail($menu_id);
        $sub_menu = SubMenu::where('menu_id', $menu_id)->get();
        $view = view('admin.sub-menu-akses.create', compact('title', 'role', 'menu', 'sub_menu'));
        $view = $view->render();
        return $view;
    }

    public function store($role_id, $menu_id, Request $request)
    {

        $role_id = Crypt::decrypt($role_id);
        $menu_id = Crypt::decrypt($menu_id);

        $validator = Validator::make($request->all(), [
            'sub_menu_id' => 'required',
            'create' => 'required',
            'read' => 'required',
            'update' => 'required',
            'delete' => 'required',
        ]);
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return redirect()->back();
        }

        $input['role_id'] = $role_id;
        $input['menu_id'] = $menu_id;
        $input['sub_menu_id'] = $request->sub_menu_id;
        $input['create'] = $request->create;
        $input['read'] = $request->read;
        $input['update'] = $request->update;
        $input['delete'] = $request->delete;
        $input['user_id'] = Auth::user()->id;

        SubMenuAccess::create($input);

        Alert::toast('Sub Menu Akses Berhasil Ditambah', 'success');
        return redirect('admin/submenus/access/' . Crypt::encrypt($role_id) . '/' . Crypt::encrypt($menu_id));
    }

    public function edit($role_id, $menu_id, $sub_menu_access)
    {
        $title = "Sub Menu Akses";

        $role_id = Crypt::decrypt($role_id);
        $menu_id = Crypt::decrypt($menu_id);
        $sub_menu_access_id = Crypt::decrypt($sub_menu_access);


        $role = Role::findOrFail($role_id);
        $menu = Menu::findOrFail($menu_id);
        $sub_menu_access = SubMenuAccess::findOrFail($sub_menu_access_id);

        $sub_menu = SubMenu::where('menu_id', $menu_id)->get();
        $view = view('admin.sub-menu-akses.edit', compact('title', 'role', 'menu', 'sub_menu', 'sub_menu_access'));
        $view = $view->render();
        return $view;
    }

    public function update(Request $request, $role_id, $menu_id, $sub_menu_access)
    {
        $sub_menu_access = Crypt::decrypt($sub_menu_access);
        $sub_menu_access = SubMenuAccess::findOrFail($sub_menu_access);
        $validator = Validator::make($request->all(), [
            'sub_menu_id' => 'required',
            'create' => 'required',
            'read' => 'required',
            'update' => 'required',
            'delete' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return redirect()->back();
        }

        $sub_menu_access->fill($request->all());

        $sub_menu_access->save();
        Alert::toast('Sub Menu Akses Berhasil Diubah', 'success');

        return redirect('admin/submenus/access/' . $role_id . '/' . $menu_id);
    }

    public function destroy($role_id, $menu_id, $sub_menu_access)
    {
        $sub_menu_access = Crypt::decrypt($sub_menu_access);
        $sub_menu_access = SubMenuAccess::where('id', $sub_menu_access)->first();

        $sub_menu_access->delete();

        Alert::toast('Sub Menu Akses Berhasil DiHapus', 'success');
        return redirect('admin/submenus/access/' . $role_id . '/' . $menu_id);
    }
}
