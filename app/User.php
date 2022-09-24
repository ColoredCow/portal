<?php

namespace App;

use App\Models\KnowledgeCafe\Library\Book;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\HR\Entities\Employee;
use Modules\Operations\Entities\OfficeLocation;
use Modules\User\Traits\HasWebsiteUser;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasWebsiteUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id', 'avatar',
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
     * Checks if the user is super admin.
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }

    public static function scopeInterviewers($query)
    {
        return $query->where('provider', 'google');
    }

    public function getAvatarAttribute($value)
    {
        return ($value) ?: url('/images/default_profile.png');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_readers', 'user_id', 'library_book_id');
    }

    public function totalReadBooks()
    {
        return $this->books()->count();
    }

    public function getIsActiveEmployeeAttribute()
    {
        // The employees will have a GSuite ID. That means the provider will be google.
        // Also, to make sure there's no false entry, we'll also check if the email
        // contains the gsuite client hd parameter.
        return $this->provider == 'google' && strpos($this->email, config('constants.gsuite.client-hd')) !== false;
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

    public function officelocation()
    {
        return $this->belongsTo(OfficeLocation::class, 'location');
    }


    public function location()
    {
        return $this->belongsTo(OfficeLocation::class, 'location_id');
    }

    public function scopeFindByEmail($query, $email)
    {
        return $query->where('email', $email);
    }
}
