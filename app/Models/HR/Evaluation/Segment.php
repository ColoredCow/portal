<?php

namespace App\Models\HR\Evaluation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segment extends Model
{
    use SoftDeletes;

    // protected $fillable = ['name'];

    // protected $table = 'hr_evaluation_parameters';

    // protected $dates = ['deleted_at'];

    // public function rounds()
    // {
    //     return $this->belongsToMany(Round::class, 'hr_round_evaluation', 'evaluation_id', 'round_id');
    // }

    // public function options()
    // {
    //     return $this->hasMany(EvaluationParameterOption::class, 'evaluation_id');
    // }
}
