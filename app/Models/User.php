<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'email',
        'type_user',
        'password',
        'level',
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
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    const ADMIN_TYPE = 1;
    const DEFAULT_TYPE = 0;

    public function canManageForms(): bool
    {
        return in_array((int) $this->level, [0, 1, 3], true);
    }

    public function backOfficeHomePath(): string
    {
        return '/forms-control';
    }
    /*public  function isAdmin()
    {
        return $this->level === self::ADMIN_TYPE;
    }*/

    public function hasRole()
    {
        switch ($this->level) {
            case 0:
                session(['level' => self::DEFAULT_TYPE]);
                return  self::DEFAULT_TYPE;
                break;
            case 1:
                session(['level' => self::DEFAULT_TYPE]);
                return  self::ADMIN_TYPE;
                break;
            case 2:
                session(['level' => self::DEFAULT_TYPE]);
                return  self::DEFAULT_TYPE;
                break;
            default:
                session(['level' => self::DEFAULT_TYPE]);
                return self::DEFAULT_TYPE;
        }
    }
}
