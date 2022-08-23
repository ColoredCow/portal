<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\Evaluation\Segment;
use Modules\HR\Database\Factories\HrApplicationSegmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationEvaluationSegment extends Model
{
    use HasFactory;
    protected $fillable = ['application_id', 'application_round_id', 'evaluation_segment_id', 'comments'];

    protected $table = 'hr_application_segments';

    public function applicationRound()
    {
        return $this->belongsTo(ApplicationRound::class);
    }
	
    public static function newFactory()
    {
        return new HrApplicationSegmentFactory();
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function evaluationSegment()
    {
        return $this->belongsTo(Segment::class);
    }
}
