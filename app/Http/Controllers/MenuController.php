<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Menu";
        $description = "Detail Menu";
        $menus = Menu::orderBy('created_at', 'desc')->get();
        return view('admin.menu.index', compact('title', 'menus', 'description'));
    }


    public function create()
    {
        $title = "Tambah Menu";
        $view = view('admin.menu.create', compact('title'));
        $view = $view->render();
        return $view;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_name' => 'required|string|max:255',
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
            'name' => $request->menu_name,
            'attribute' => $request->attribute,
            'link' => $request->link,
            'position' => $request->position,
            'description' => $request->description,
            'category' => $request->category,
        ];

        Menu::create($input);
        Alert::toast('Menu Berhasil Ditambah', 'success');
        return redirect('/admin/menus');
    }

    public function edit(menu $menu, $menuId)
    {
        $id = crypt::decrypt($menuId);
        $menu = Menu::findOrFail($id);
        $title = "Edit Menu";
        $view = view('admin.menu.edit', compact('title',  'menu'));
        $view = $view->render();
        return $view;
    }

    public function update(Request $request, $menuId)
    {

        $id = Crypt::decrypt($menuId);
        $menu = Menu::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'menu_name' => 'nullable|string|max:255',
            'attribute' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return redirect()->back();
        }

        $input = [
            'name' => $request->menu_name,
            'attribute' => $request->attribute,
            'link' => $request->link,
            'position' => $request->position,
            'description' => $request->description,
            'category' => $request->category,
        ];

        $menu->update($input);
        Alert::toast('Menu Berhasil DiUbah', 'success');
        
        return redirect('/admin/menus');
    }
    
    public function destroy(Request $request)
    {
        $menuId = Crypt::decrypt($request->id);
        $menu = Menu::findOrFail($menuId);
        $menu->delete();
        Alert::toast('Menu Berhasil DiHapus', 'success');
        return redirect('/admin/menus');
    }
}
