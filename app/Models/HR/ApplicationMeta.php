<?php

namespace App\Models\HR;

use App\Models\HR\Application;
use Illuminate\Database\Eloquent\Model;

class ApplicationMeta extends Model
{
    protected $fillable = ['hr_application_id', 'value', 'key'];

    protected $table = 'hr_application_meta';

    public function application()
    {
    	return $this->belongsTo(Application::class, 'hr_application_id');
    }

    public static function scopeFormData($query)
    {
        return $query->where('key', 'form-data');
    }
}
