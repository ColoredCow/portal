<?php

namespace App\Models\HR\Evaluation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParameterOption extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['evaluation_id', 'value'];

    protected $table = 'hr_evaluation_parameter_options';

    protected $dates = ['deleted_at'];

    public function evaluationParameter()
    {
        return $this->belongsTo(Parameter::class, 'evaluation_id');
    }
}
