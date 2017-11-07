<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Ultraware\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContracts;
use Ultraware\Roles\Traits\HasRoleAndPermission;
class User extends Authenticatable implements HasRoleAndPermissionContracts
{
    use Notifiable, HasRoleAndPermission;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}