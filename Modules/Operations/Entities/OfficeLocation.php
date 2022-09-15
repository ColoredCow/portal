<?php

namespace Modules\Operations\Entities;

use App\User;
use Modules\HR\Entities\Employee;
use Illuminate\Database\Eloquent\Model;

class OfficeLocation extends Model
{
    protected $table = 'office_locations';
    
    protected $fillable = [
        'center_head',
        'location',
        'capacity',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'center_head');
    }
}
