<?php

namespace Modules\HR\Entities\Evaluation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\HR\Entities\Round;

class Parameter extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'segment_id', 'marks', 'parent_id', 'parent_option_id'];

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

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function parentOption()
    {
        return $this->belongsTo(ParameterOption::class, 'parent_option_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->with(['parent', 'parentOption']);
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
