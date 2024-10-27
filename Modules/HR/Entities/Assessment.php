<?php
namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    public $timestamps = true;
    protected $table = 'assessments';
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'reviewee_id');
    }

    public function individualAssessments()
    {
        return $this->hasMany(IndividualAssessment::class);
    }

    public function assessmentReviewStatus($assessment, $role, $key)
    {
        $individualAssessmentId = false;
        $individualAssessmentStatus = false;
        $individualAssessmentType = false;

        foreach ($assessment->individualAssessments as $individualAssessment) {
            $individualAssessmentId = $individualAssessment->assessment_id == $assessment->id;
            $individualAssessmentType = $individualAssessment->type == $role;
            $individualAssessmentStatus = $individualAssessment->status == $key;

            if ($individualAssessmentId && $individualAssessmentType && $individualAssessmentStatus) {
                break;
            }
        }

        return $individualAssessmentId && $individualAssessmentType && $individualAssessmentStatus;
    }
}
