<?php

namespace App\Models\HR;

use App\Models\HR\Round;
use Illuminate\Database\Eloquent\Model;

class EvaluationParameter extends Model
{
    protected $fillable = ['name'];

    protected $table = 'hr_evaluation_parameters';

    public function rounds()
    {
    	return $this->belongsToMany(Round::class, 'hr_round_evaluation', 'evaluation_id', 'round_id');
    }
}
