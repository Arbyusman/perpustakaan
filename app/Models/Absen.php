<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absen extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'attendance_date',
        'check_in',
        'status_check_in',
        'check_out',
        'status_check_out',
        'total_work_time',
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
