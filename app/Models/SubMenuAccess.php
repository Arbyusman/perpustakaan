<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubMenuAccess extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'menu_access_id',
        'role_id',
        'menu_id',
        'sub_menu_id',
        'create',
        'read',
        'update',
        'delete',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function subMenu()
    {
        return $this->belongsTo(SubMenu::class, 'sub_menu_id');
    }
}
