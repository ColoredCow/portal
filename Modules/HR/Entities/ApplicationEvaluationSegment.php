<?php

namespace Modules\HR\Entities;

use App\Models\HR\Application;
use App\Models\HR\ApplicationRound;
use App\Models\HR\Evaluation\Segment;
use Illuminate\Database\Eloquent\Model;

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
