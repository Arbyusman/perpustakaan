<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubMenu extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =[
        'menu_id',
        'name',
        'link',
        'attribute',
        'position',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function subMenuAccess()
    {
        return $this->hasOne(SubMenuAccess::class, 'menu_id');
    }
}
