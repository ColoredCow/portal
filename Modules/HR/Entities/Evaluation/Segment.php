<?php

namespace Modules\HR\Entities\Evaluation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\HR\Entities\ApplicationEvaluationSegment;
use Modules\HR\Entities\Round;
use Modules\HR\Database\Factories\HrApplicationEvaluationSegmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Segment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'round_id'];

    protected $table = 'hr_evaluation_segments';

    protected $dates = ['deleted_at'];

    public function round()
    {
        return $this->belongsTo(Round::class);
    }
    public static function newFactory()
    {
        return new HrApplicationEvaluationSegmentFactory();
    }

    public function parameters()
    {
        return $this->hasMany(Parameter::class, 'segment_id');
    }

    public function applicationEvaluations()
    {
        return $this->hasMany(ApplicationEvaluationSegment::class, 'evaluation_segment_id');
    }
}
