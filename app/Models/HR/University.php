<?php

namespace App\Models\HR;

use App\Models\HR\UniversityContact;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = ['name','address','rating'];

    protected $table = 'hr_universities';

    public function universityContacts()
    {
        return $this->hasMany(UniversityContact::class, 'hr_university_id');
    }
    public static function getUniversities($filteredString = false)
    {
        if (!$filteredString) {
            return self::latest()->paginate(config('constants.pagination_size'));
        }
        return self::where('name', 'like', '%'.$filteredString.'%')
            ->orWhere('address', 'like', "%$filteredString%")
            ->orWhereHas('universityContacts', function ($query) use ($filteredString) {
                $query->where('name', 'like', '%'.$filteredString.'%')
                ->orWhere('email', 'like', "%$filteredString%")
                ->orWhere('designation', 'like', "%$filteredString%")
                ->orWhere('phone', 'like', "%$filteredString%");
            })
            ->latest()->paginate(config('constants.pagination_size'));
    }
}
