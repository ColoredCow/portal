<?php

namespace App\Models\HR;

use App\Models\HR\Round;
use Illuminate\Database\Eloquent\Model;

class EvaluationParameterOption extends Model
{
    protected $fillable = ['evaluation_id', 'value'];

    protected $table = 'hr_evaluation_parameter_options';

    public function rounds()
    {
    	return $this->belongsToMany(Round::class, 'hr_round_evaluation', 'evaluation_id', 'round_id');
    }
}
