<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =[
        'name',
        'attribute',
        'link',
        'position',
        'category',
    ];

    public function subMenu()
    {
        return $this->hasOne(Menu::class, 'menu_id');
    }

    public function menuAccess()
    {
        return $this->hasOne(MenuAccess::class, 'menu_id');
    }
    public function subMenuAccess()
    {
        return $this->hasOne(SubMenuAccess::class, 'menu_id');
    }

    
}
