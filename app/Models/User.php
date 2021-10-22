<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'balance',
        'phone',
        'sponsor_username',
        'club_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function headTails()
    {
        return $this->hasMany(HeadTail::class);
    }

    public function evenOdds()
    {
        return $this->hasMany(EvenOdd::class);
    }

    public function kings()
    {
        return $this->hasMany(Kings::class);
    }

    public function ludos()
    {
        return $this->hasMany(Ludo::class);
    }


    public function getIsAdminAttribute()
    {
        return $this->hasRole('Admin');
    }

    public function getIsUserAttribute()
    {
        return $this->hasRole('User');
    }

    public function getBalanceTransferHistoryAttribute()
    {
        return BalanceTransfer::where('from', $this->username)
        ->orWhere('to', $this->username)
        ->latest()
        ->get();
    }
}
