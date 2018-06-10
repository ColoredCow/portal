<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\KnowledgeCafe\Library\Book;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function findByEmail($email)
    {
        return self::where('email', $email)->first();
    }

    /**
     * Checks if the user is super admin
     *
     * @return boolean
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }

    public static function scopeInterviewers($query)
    {
        return $query->where('provider', 'google');
    }

    public function getAvatarAttribute($value) {
        return ($value) ? : url('/images/default_profile.png');
    }

    public function books() {
        return $this->belongsToMany(User::class, 'book_readers', 'user_id', 'library_book_id');
    }
}
