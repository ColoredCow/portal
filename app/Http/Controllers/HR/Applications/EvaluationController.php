<?php

namespace App\Http\Controllers\HR\Applications;

use App\Http\Controllers\Controller;
use App\Models\HR\ApplicationRound;
use App\Models\HR\Evaluation\Segment;

class EvaluationController extends Controller
{
    public function show($applicationRoundID)
    {
        $applicationRound = ApplicationRound::find($applicationRoundID)->load('application.applicant');

        $segmentList = array();

        foreach (self::getSegments($applicationRound->hr_application_id) as $segment) {
            $segmentList[] = self::getSegmentDetails($segment);
        }

        return view('hr.application.evaluation-form')->with(['segment' => $segmentList, 'applicationRound' => $applicationRound])->render();
    }

    public function update($applicationRoundId)
    {
        $applicationRound = ApplicationRound::find($applicationRoundId);

        if (array_key_exists('evaluation', request()->all())) {
            $applicationRound->updateOrCreateEvaluation(request()->all()['evaluation']);
        }
        if (array_key_exists('evaluation_segment', request()->all())) {
            $applicationRound->updateOrCreateEvaluationSegment(request()->all()['evaluation_segment']);
        }

        return redirect()->back()->with('status', 'Evaluation updated successfully!');
    }

    private function getSegments($applicationId)
    {
        return Segment::whereHas('round')->with(
            [
                'round',
                'applicationEvaluations' => function ($query) use ($applicationId) {
                    $query->where('application_id', $applicationId);
                },
                'parameters',
                'parameters.options',
                'parameters.applicationEvaluation' => function ($query) use ($applicationId) {
                    $query->where('application_id', $applicationId);
                    $query->with('evaluationOption');
                },
            ]
        )->get();
    }

    private function getSegmentGeneralInfo($segment)
    {
        $segmentGeneralInfo = array();

        $segmentGeneralInfo['id'] = $segment->id;
        $segmentGeneralInfo['name'] = $segment->name;
        $segmentGeneralInfo['round'] = $segment->round->name;
        $segmentGeneralInfo['round_id'] = $segment->round_id;

        return $segmentGeneralInfo;
    }

    private function getParameterGeneralInfo($parameter)
    {
        $parameterGeneralInfo = array();

        $parameterGeneralInfo['id'] = $parameter->id;
        $parameterGeneralInfo['name'] = $parameter->name;

        return $parameterGeneralInfo;
    }

    private function getEvaluationDetails($evaluation)
    {
        $evaluationDetails = array();

        $evaluationDetails['comment'] = $evaluation->comment;
        $evaluationDetails['option'] = $evaluation->evaluationOption->value;

        return $evaluationDetails;
    }

    private function getOptionsDetails($options)
    {
        $optionList = array();

        foreach ($options as $option) {
            $optionList[] = [
                'id' => $option->id,
                'name' => $option->value
            ];
        }

        return $optionList;
    }

    private function getParameterInfo($parameter)
    {
        $parameterDetails = array();

        $parameterDetails = self::getParameterGeneralInfo($parameter);

        if ($parameter->applicationEvaluation) {
            $parameterDetails['evaluation'] = true;
            $parameterDetails['evaluation_detail'] = self::getEvaluationDetails($parameter->applicationEvaluation);
        } else {
            $parameterDetails['evaluation'] = false;
            $parameterDetails['option_detail'] = self::getOptionsDetails($parameter->options);
        }

        return $parameterDetails;
    }

    private function getSegmentParameters($segmentParameters)
    {
        $parameters = array();

        foreach ($segmentParameters as $parameter) {
            $parameters[] = self::getParameterInfo($parameter);
        }

        return $parameters;
    }

    private function getSegmentApplicationEvaluations($segmentApplicationEvaluations)
    {
        $applicationEvaluations = array();
        $comments = null;
        // this for loop will run just once as the maximum size of $segmentApplicationEvaluations will be one.
        foreach ($segmentApplicationEvaluations as $segmentApplicationEvaluation) {
            $comments = $segmentApplicationEvaluation->comments;
        }
        return [
            'comments' => $comments,
        ];
    }

    private function getSegmentDetails($segment)
    {
        $segmentDetails = array();

        $segmentDetails = self::getSegmentGeneralInfo($segment);
        $segmentDetails['parameters'] = self::getSegmentParameters($segment->parameters);
        $segmentDetails['applicationEvaluations'] = self::getSegmentApplicationEvaluations($segment->applicationEvaluations); // there will be just one segment data for an application

        return $segmentDetails;
    }
}
