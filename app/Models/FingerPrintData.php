<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FingerPrintData extends Model
{
    use HasFactory;

    protected $fillable =[
        'finger_print_id',
    ];
}
