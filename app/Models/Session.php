<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\CodeTrek\Entities\CodeTrekApplicant;

class Session extends Model
{
    protected $fillable = ['topic_name', 'date','link', 'summary'];

    use HasFactory;

    public function codetrekApplicants()
    {
        return $this->morphedByMany(CodeTrekApplicant::class, 'model', 'model_has_sessions');
    }
}
