<?php

namespace App\Models\HR\Evaluation;

use App\Models\HR\Round;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parameter extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'segment_id'];

    protected $table = 'hr_evaluation_parameters';

    protected $dates = ['deleted_at'];

    public function rounds()
    {
        return $this->belongsToMany(Round::class, 'hr_round_evaluation', 'evaluation_id', 'round_id');
    }

    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }

    public function options()
    {
        return $this->hasMany(ParameterOption::class, 'evaluation_id');
    }

    public function applicationEvaluation()
    {
        return $this->hasOne(ApplicationEvaluation::class, 'evaluation_id');
    }

    public static function parameterList()
    {
        return self::query()
            ->has('segment')
            ->with(['segment', 'segment.round', 'options'])
            ->get()
            ->groupBy('segment_id')
            ->toArray();
    }
}
