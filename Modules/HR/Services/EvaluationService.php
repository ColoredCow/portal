<?php

namespace Modules\HR\Services;

use Modules\HR\Contracts\EvaluationServiceContract;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Round;

class EvaluationService implements EvaluationServiceContract
{
    public function evaluationResult($applicationRound, $evaluationScores)
	{
		// return $status;
	}
}