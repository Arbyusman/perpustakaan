<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuAccessRequest;
use App\Http\Requests\UpdateMenuAccessRequest;
use App\Models\Menu;
use App\Models\MenuAccess;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class MenuAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($role_id)
    {
        $title = "Menu Akses";

        $role_id = Crypt::decrypt($role_id);
        $role = Role::findOrFail($role_id);
        $description = "Menu Akses dari Role:" . $role->name;

        $role_access = MenuAccess::select('menu_accesses.*', 'name')
            ->leftJoin('menus', 'menu_accesses.menu_id', '=', 'menus.id')
            ->where('role_id', $role_id)
            ->orderBy('position', 'ASC')->get();

        return view('admin.menu-akses.index', compact('title', 'role_id', 'role', 'role_access', 'description'));
    }


    public function create($role_id)
    {
        $title = "Tambah Menu Akses";

        $id = Crypt::decrypt($role_id);
        $role = Role::where('id', $id)->first();

        $existingMenuIds = MenuAccess::where('role_id', $id)->pluck('menu_id');

        $menu = Menu::whereNotIn('id', $existingMenuIds)->get();

        $view = view('admin.menu-akses.create', compact('title', 'role', 'menu'));
        $view = $view->render();
        return $view;
    }

    public function store(Request $request, $role_id)
    {
        $role = Crypt::decrypt($role_id);

        $validator = Validator::make($request->all(), [
            'menu_id' => 'required',
            'create' => 'required',
            'read' => 'required',
            'update' => 'required',
            'delete' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return redirect()->back();
        }
        $input['role_id'] = $role;
        $input['menu_id'] = $request->menu_id;
        $input['create'] = $request->create;
        $input['read'] = $request->read;
        $input['update'] = $request->update;
        $input['delete'] = $request->delete;
        MenuAccess::create($input);

        Alert::toast('Menu Akses Berhasil Di Tambah', 'success');
        return redirect('admin/menus/access/' . Crypt::encrypt($role));
    }


    public function edit($menuAccesessId, $role_id)
    {
        $title = "Edit Menu Akses";

        $id = Crypt::decrypt($role_id);
        $role = Role::findOrFail($id);

        $menu = Menu::all();
        $menuAccesess = Crypt::decrypt($menuAccesessId);
        $menuAccesess = MenuAccess::findOrFail($menuAccesess);
        $view = view('admin.menu-akses.edit', compact('title', 'role', 'menu', 'menuAccesess'));
        $view = $view->render();
        return $view;
    }

    public function update(Request $request, $menuAccesessId, $role_id)
    {
        $id = Crypt::decrypt($menuAccesessId);
        $menuAccesess = MenuAccess::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'menu_id' => 'nullable',
            'create' => 'nullable',
            'read' => 'nullable',
            'update' => 'nullable',
            'delete' => 'nullable',
        ]);
        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return redirect()->back();
        }

        $input['menu_id'] = $request->menu_id;
        $input['create'] = $request->create;
        $input['read'] = $request->read;
        $input['update'] = $request->update;
        $input['delete'] = $request->delete;

        $menuAccesess->update($input);

        Alert::toast('Menu Akses Berhasil Di Ubah', 'success');
        return redirect('admin/menus/access/' . $role_id);
    }

    public function destroy(Request $request, $role_id)
    {
        $id =  Crypt::decrypt($request->id);
        $role_access = MenuAccess::findOrFail($id);
        $role_access->delete();

        Alert::toast('Menu Akses Berhasil Di Hapus', 'success');
        return redirect('admin/menus/access/' . $role_id);
    }
}
