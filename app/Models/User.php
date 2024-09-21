<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'jenis_kelamin',
        'avatar',
        'phone',
        'nik',
        'address',
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function policeRank()
    {
        return $this->belongsTo(PoliceRank::class, 'police_rank_id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function flightPlan()
    {
        return $this->hasOne(FlightPlan::class, 'pilot_in_command');
    }

    public function flightPlanCreate()
    {
        return $this->hasOne(FlightPlan::class, 'created_by');
    }
    public function flightPlanUpdate()
    {
        return $this->hasOne(FlightPlan::class, 'updated_by');
    }
    public function flightPlanDelete()
    {
        return $this->hasOne(FlightPlan::class, 'deleted_by');
    }
}
