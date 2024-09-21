<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuAccessController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubMenuAccessController;
use App\Http\Controllers\SubMenuController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Auth::routes(['verify' => true]);

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';


Route::middleware(['role_web:1', 'verified'])->group(function () {

    // User
    Route::controller(UserController::class)->group(function () {
        Route::get('admin/users', 'index')->name("users.index");
        Route::get('admin/users/create', 'create')->name("users.create");
        Route::post('admin/users/create', 'store')->name("users.store");
        Route::get('admin/users/edit/{id}', 'edit')->name("users.edit");
        Route::put('admin/users/update/{id}', 'update')->name("users.update");
        Route::get('user/edit/profile/{id}', 'editProfile')->name("profile.edit");
        Route::post('user/update/profile/{id}', 'updateProfile')->name("profile.update");
        Route::post('admin/users/delete', 'destroy')->name("users.delete");
        Route::post('admin/users/reset-password/{id}', 'resetPassword')->name('users.resetPassword');
    });

    ## Role
    Route::controller(RoleController::class)->group(function () {
        Route::get('admin/roles', 'index')->name('roles.index');
        Route::get('admin/roles/create', 'create')->name('roles.create');
        Route::post('admin/roles/store', 'store')->name('roles.store');
        Route::get('admin/roles/edit/{id}', 'edit')->name('roles.edit');
        Route::put('admin/roles/update/{id}', 'update')->name('roles.update');
        Route::delete('admin/roles/hapus/{id}', 'destroy')->name('roles.delete');
    });

    ## Menu
    Route::controller(MenuController::class)->group(function () {
        Route::get('admin/menus', 'index')->name('menus.index');
        Route::get('admin/menus/search', 'search')->name('menus.search');
        Route::get('admin/menus/create', 'create')->name('menus.create');
        Route::post('admin/menus/store', 'store')->name('menus.store');
        Route::get('admin/menus/edit/{id}', 'edit')->name('menus.edit');
        Route::put('admin/menus/update/{id}', 'update')->name('menus.update');
        Route::delete('admin/menus/hapus/{id}', 'destroy')->name('menus.delete');
    });

    ## Sub Menu
    Route::controller(SubMenuController::class)->group(function () {
        Route::get('admin/submenus/{menu_id}', 'index')->name('submenus.index');
        Route::get('admin/submenus/search/{menu_id}', 'search')->name('submenus.search');
        Route::get('admin/submenus/create/{menu_id}', 'create')->name('submenus.create');
        Route::post('admin/submenus/store/{menu_id}', 'store')->name('submenus.store');
        Route::get('admin/submenus/edit/{menu_id}/{id}', 'edit')->name('submenus.edit');
        Route::put('admin/submenus/update/{menu_id}/{id}', 'update')->name('submenus.update');
        Route::delete('admin/submenus/hapus/{menu_id}/{id}', 'destroy')->name('submenus.delete');
    });

    ## Menu Akses
    Route::controller(MenuAccessController::class)->group(function () {
        Route::get('admin/menus/access/{role_id}', 'index')->name('menu_access.index');
        Route::get('admin/menus/access/search/{role_id}', 'search')->name('menu_access.search');
        Route::get('admin/menus/access/create/{role_id}', 'create')->name('menu_access.create');
        Route::post('admin/menus/access/store/{role_id}', 'store')->name('menu_access.store');
        Route::get('admin/menus/access/edit/{role_id}/{id}', 'edit')->name('menu_access.edit');
        Route::put('admin/menus/access/update/{role_id}/{id}', 'update')->name('menu_access.update');
        Route::delete('admin/menus/access/hapus/{role_id}/{id}', 'destroy')->name('menu_access.delete');
    });

    ## Sub Menu Akses
    Route::controller(SubMenuAccessController::class)->group(function () {
        Route::get('admin/submenus/access/{role_id}/{menu_id}', 'index')->name('submenu_access.index');
        Route::get('admin/submenus/access/search/{role_id}/{menu_id}', 'search')->name('submenu_access.search');
        Route::get('admin/submenus/access/create/{role_id}/{menu_id}', 'create')->name('submenu_access.create');
        Route::post('admin/submenus/access/store/{role_id}/{menu_id}', 'store')->name('submenu_access.store');
        Route::get('admin/submenus/access/edit/{role_id}/{menu_id}/{id}', 'edit')->name('submenu_access.edit');
        Route::put('admin/submenus/access/update/{role_id}/{menu_id}/{id}', 'update')->name('submenu_access.update');
        Route::delete('admin/submenus/access/hapus/{role_id}/{menu_id}/{id}', 'destroy')->name('submenu_access.delete');
    });


    ## Setting
    Route::controller(SettingController::class)->group(function () {
        Route::get('admin/settings', 'edit')->name("settings.edit");
        Route::post('admin/settings', 'update')->name("settings.update");
    });


});
