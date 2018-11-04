<?php

namespace App\Domain\Entities;

use App\Domain\Entities\Entities;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Entities implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Notifiable;

    // use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'level', 'pin','verifikasi',
    ];

    protected $table ='users';
    protected $hidden = [
        'password', 'remember_token',
    ];

}
