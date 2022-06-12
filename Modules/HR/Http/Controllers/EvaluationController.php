<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Entities\Round;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\Evaluation\Parameter;
use Modules\HR\Entities\Evaluation\ParameterOption;
use Modules\HR\Entities\Evaluation\Segment;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $segments = Segment::all();

        return view('hr::evaluation.index', [
            'segments' => $segments
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function segmentParameters(Request $request, $segmentID)
    {
        $segment = Segment::find($segmentID);

        return view('hr::evaluation.segment-parameters', [
            'segment' => $segment,
            'parameters' => $segment->parameters()->with('options')->get(),
            'parentParameters' => $segment->parameters()->whereNull('parent_id')->with('options')->get(),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function createSegment(Request $request)
    {
        $segment = Segment::create(['name' => $request->name]);

        return redirect(route('hr.evaluation'));
    }

    /**
     * Display a listing of the resource.
     */
    public function updateSegment(Request $request, $segmentID)
    {
        $segment = Segment::find($segmentID);
        $segment->update(['name' => $request->name]);

        return redirect(route('hr.evaluation'));
    }

    public function createSegmentParameter(Request $request, $segmentID)
    {
        $segment = Segment::find($segmentID);
        $parameter = Parameter::create([
                'name' => $request->name,
                'marks' => $request->marks,
                'segment_id' => $segment->id
        ]);

        foreach ($request->parameter_options as $parameterOption) {
            ParameterOption::create([
                'value' => $parameterOption['label'],
                'marks' => $parameterOption['marks'],
                'evaluation_id' => $parameter->id
            ]);
        }

        return redirect(route('hr.evaluation.segment-parameters', $segment->id));
    }

    public function updateSegmentParameter(Request $request, $segmentID, $parameterID)
    {
        $parameter = Parameter::find($parameterID);
        $parameter->update(['name' => $request->name, 'marks' => $request->marks]);
        $parameterNewOptions = collect([]);

        foreach ($request->parameter_options as $parameterOptionData) {
            $id = $parameterOptionData['id'] ?? null;
            if ($id) {
                $parameterOption = ParameterOption::find($id);
                $parameterOption->update([
                    'value' => $parameterOptionData['label'],
                    'marks' => $parameterOptionData['marks'],
                    'evaluation_id' => $parameter->id
                ]);
                $parameterNewOptions->push($parameterOption);
                continue;
            }

            $parameterOption = ParameterOption::create([
                'value' => $parameterOptionData['label'],
                'marks' => $parameterOptionData['marks'],
                'evaluation_id' => $parameter->id
            ]);

            $parameterNewOptions->push($parameterOption);
        }

        $parameter->options
            ->diff($parameterNewOptions)
            ->each(function ($parameterOption) {
                $parameterOption->delete();
            });

        return redirect(route('hr.evaluation.segment-parameters', $segmentID));
    }

    public function updateSegmentParameterParent(Request $request, $segmentID, $parameterID)
    {
        $parameter = Parameter::find($parameterID);
        if ($request->parent_parent_id == $parameterID) {
            return redirect(route('hr.evaluation.segment-parameters', $segmentID));
        }
        $parameter->update(['parent_id' => $request->parent_parent_id, 'parent_option_id' => $request->parent_option_id]);

        return redirect(route('hr.evaluation.segment-parameters', $segmentID));
    }

    public function show($applicationRoundId)
    {
        $applicationRound = ApplicationRound::find($applicationRoundId)->load('application.applicant');

        $segmentList = [];

        foreach (self::getSegments($applicationRound->hr_application_id) as $segment) {
            $segmentList[] = self::getSegmentDetails($segment);
        }

        $evaluationScores = self::calculateEvaluationScores($segmentList);

        return view('hr.application.evaluation-form')->with([
            'segment' => $segmentList,
            'applicationRound' => $applicationRound,
            'evaluationScores' => $evaluationScores,
            'employees' => Employee::active()->orderBy('name')->get(),
        ])->render();
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
		$status = 'Evaluation updated successfully!';

        if ($applicationRound->hr_round_id == Round::where('name', 'Resume Screening')->first()->id) {
            $segmentList = [];
            foreach (self::getSegments($applicationRound->hr_application_id) as $segment) {
                $segmentList[] = self::getSegmentDetails($segment);
            }
            $evaluationScores = self::calculateEvaluationScores($segmentList);
			$application = Application::find($applicationRound->hr_application_id);
			$applicant = Applicant::find($application->hr_applicant_id);

			if ($evaluationScores['score'] >= 2) {
				$application->untag('new-application');
				$application->tag('in-progress');
				$nextApplicationRound = $application->job->rounds->where('id', 2)->first();
				$scheduledPersonId = $nextApplicationRound->pivot->hr_round_interviewer_id ?? config('constants.hr.defaults.scheduled_person_id');
				$applicationRound = ApplicationRound::updateOrCreate([
					'hr_application_id' => $application->id,
					'hr_round_id' => Round::where('name', 'Introductory Call')->first()->id,
					'trial_round_id' => 1,
					'round_status' => 'confirmed',
					'scheduled_date' => now(),
					'scheduled_end' => now(),
					'scheduled_person_id' => $scheduledPersonId,
				]);
				$status = 'Application success!';
			} else {
				$application->untag('new-application');
				$applicationRound->round_status = 'rejected';
				foreach ($applicant->applications as $applicantApplication) {
					$applicantApplication->reject();
				}
				$status = 'Application reject!';
			}
        }

        return redirect()->back()->with('status', $status);
    }

    private function getSegments($applicationId)
    {
        return Segment::whereHas('round')->orWhereNull('round_id')->with(
            [
                'round',
                'applicationEvaluations' => function ($query) use ($applicationId) {
                    $query->where('application_id', $applicationId);
                },
                'parameters' => function ($query) {
                    $query->whereNull('parent_id');
                },
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
        $segmentGeneralInfo = [];

        $segmentGeneralInfo['id'] = $segment->id;
        $segmentGeneralInfo['name'] = $segment->name;
        $segmentGeneralInfo['round'] = optional($segment->round)->name;
        $segmentGeneralInfo['round_id'] = $segment->round_id;

        return $segmentGeneralInfo;
    }

    private function getParameterGeneralInfo($parameter)
    {
        $parameterGeneralInfo = [];
        $parameterGeneralInfo['id'] = $parameter->id;
        $parameterGeneralInfo['name'] = $parameter->name;

        return $parameterGeneralInfo;
    }

    private function getEvaluationDetails($evaluation)
    {
        $evaluationDetails = [];

        $evaluationDetails['comment'] = $evaluation->comment;
        $evaluationDetails['option'] = $evaluation->evaluationOption->value;
        $evaluationDetails['marks'] = $evaluation->evaluationOption->marks;

        return $evaluationDetails;
    }

    private function getOptionsDetails($options)
    {
        $optionList = [];

        foreach ($options as $option) {
            $optionList[] = [
                'id' => $option->id,
                'name' => $option->value,
                'marks' => $option->marks,
            ];
        }

        return $optionList;
    }

    private function getParameterInfo($parameter)
    {
        if (! $parameter) {
            return;
        }

        $parameterDetails = self::getParameterGeneralInfo($parameter);

        $parameterDetails['marks'] = $parameter->marks;
        $parameterDetails['option_detail'] = self::getOptionsDetails($parameter->options);

        $parameterDetails['evaluation'] = false;
        $parameterDetails['evaluation_detail'] = [];
        if ($parameter->applicationEvaluation) {
            $parameterDetails['evaluation'] = true;
            $parameterDetails['evaluation_detail'] = self::getEvaluationDetails($parameter->applicationEvaluation);
        }

        $parameterDetails['children'] = [];
        foreach ($parameter->children as $childParameter) {
            $parameterDetails['children'][] = self::getParameterInfo($childParameter);
        }

        // the if condition below will run only in recursive calls.
        if ($parameter->parent_id) {
            $parameterDetails['parent_option'] = head(self::getOptionsDetails([$parameter->parentOption]));
        }

        return $parameterDetails;
    }

    private function getSegmentParameters($segmentParameters)
    {
        $parameters = [];

        foreach ($segmentParameters as $parameter) {
            $parameters[] = self::getParameterInfo($parameter);
        }

        return $parameters;
    }

    private function getSegmentApplicationEvaluations($segmentApplicationEvaluations)
    {
        $applicationEvaluations = [];
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
        $segmentDetails = [];

        $segmentDetails = self::getSegmentGeneralInfo($segment);
        $segmentDetails['parameters'] = self::getSegmentParameters($segment->parameters);

        // there will be just one segment data for an application
        $segmentDetails['applicationEvaluations'] = self::getSegmentApplicationEvaluations($segment->applicationEvaluations);

        return $segmentDetails;
    }

    private function calculateEvaluationScores($segmentList)
    {
        $scores = [
            'score' => 0,
            'max' => 0
        ];
        foreach ($segmentList as $segment) {
            $scores[$segment['round_id']][$segment['id']] = [
                'score' => 0,
                'max' => 0,
            ];
            foreach ($segment['parameters'] as $parameter) {
                $scores[$segment['round_id']][$segment['id']]['max'] += $parameter['marks'];
                if (isset($parameter['evaluation_detail']['marks'])) {
                    $scores[$segment['round_id']][$segment['id']]['score'] += $parameter['evaluation_detail']['marks'];
                }
            }
            $scores['score'] += $scores[$segment['round_id']][$segment['id']]['score'];
            $scores['max'] += $scores[$segment['round_id']][$segment['id']]['max'];
        }

        return $scores;
    }
}
