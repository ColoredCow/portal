<?php

namespace Modules\HR\Services;

use Modules\HR\Contracts\EvaluationServiceContract;

class EvaluationService implements EvaluationServiceContract
{
    public function evaluationResult($applicationRound, $evaluationScores)
    {
        // return $status;
        //TODO: We need to refactor the evaluation code if we make other rounds segment and parameter based
    }
}
