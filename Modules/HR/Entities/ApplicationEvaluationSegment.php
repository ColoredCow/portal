<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Entities\Evaluation\Segment;

class ApplicationEvaluationSegment extends Model
{
    protected $fillable = ['application_id', 'application_round_id', 'evaluation_segment_id', 'comments'];

    protected $table = 'hr_application_segments';

    public function applicationRound()
    {
        return $this->belongsTo(ApplicationRound::class);
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
