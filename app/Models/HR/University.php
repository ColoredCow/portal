<?php

namespace App\Models\HR;

use App\Models\HR\UniversityContact;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = ['name','address','rating'];

    protected $table = 'hr_universities';

    public function universityContacts(){
        return $this->hasMany(UniversityContact::class,'hr_university_id');
    }
    public static function getList($filteredString = false)
    {
        if(!$filteredString){
        return self::latest()->paginate(config('constants.pagination_size'));
        }
        else{
        return self::where('name', 'like', '%'.$filteredString.'%')->latest()->paginate(config('constants.pagination_size'));
        }
    }
}
