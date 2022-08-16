<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\Evaluation\Parameter;
use Modules\HR\Entities\Evaluation\ParameterOption;
use Modules\HR\Entities\Evaluation\Segment;
use Modules\HR\Entities\Round;
use Modules\HR\Http\Requests\ManageEvaluationRequest;
use Modules\HR\Http\Requests\EditEvaluationRequest;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $segments = Segment::all();
        $rounds = Round::select('id', 'name')->get();

        return view('hr::evaluation.index', [
            'segments' => $segments,
            'rounds' => $rounds,
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
            'parameters' => $segment
                ->parameters()
                ->with('options')
                ->get(),
            'parentParameters' => $segment
                ->parameters()
                ->whereNull('parent_id')
                ->with('options')
                ->get(),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function createSegment(ManageEvaluationRequest $request)
    {
        $segmentId = Round::select('*')->where('name', $request->rounds)->first()->id;
        $segment = Segment::create([
            'name' => $request->name,
            'round_id' => $segmentId
        ]);

        return redirect(route('hr.evaluation'));
    }

    /**
     * Display a listing of the resource.
     */
    public function updateSegment(EditEvaluationRequest $request, $segmentID)
    {
        $segment = Segment::find($segmentID);
        $segment->update([
            'name' => $request->name,
            'round_id' => $request->round_id,
        ]);

        return redirect(route('hr.evaluation'));
    }

    public function createSegmentParameter(Request $request, $segmentID)
    {
        $segment = Segment::find($segmentID);
        $parameter = Parameter::create([
            'name' => $request->name,
            'marks' => $request->marks,
            'slug' => \Str::slug($request->slug),
            'segment_id' => $segment->id,
        ]);

        foreach ($request->parameter_options as $parameterOption) {
            ParameterOption::create([
                'value' => $parameterOption['label'],
                'marks' => $parameterOption['marks'],
                'evaluation_id' => $parameter->id,
            ]);
        }

        return redirect(route('hr.evaluation.segment-parameters', $segment->id));
    }

    public function updateSegmentParameter(Request $request, $segmentID, $parameterID)
    {
        $parameter = Parameter::find($parameterID);
        $parameter->update(['name' => $request->name, 'marks' => $request->marks, 'slug' => \Str::slug($request->slug)]);
        $parameterNewOptions = collect([]);

        foreach ($request->parameter_options as $parameterOptionData) {
            $id = $parameterOptionData['id'] ?? null;
            if ($id) {
                $parameterOption = ParameterOption::find($id);
                $parameterOption->update([
                    'value' => $parameterOptionData['label'],
                    'marks' => $parameterOptionData['marks'],
                    'evaluation_id' => $parameter->id,
                ]);
                $parameterNewOptions->push($parameterOption);
                continue;
            }

            $parameterOption = ParameterOption::create([
                'value' => $parameterOptionData['label'],
                'marks' => $parameterOptionData['marks'],
                'evaluation_id' => $parameter->id,
            ]);

            $parameterNewOptions->push($parameterOption);
        }

        $parameter->options->diff($parameterNewOptions)->each(function ($parameterOption) {
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

        foreach (self::getSegments($applicationRound->hr_application_id, $applicationRound->round) as $segment) {
            $segmentList[] = self::getSegmentDetails($segment);
        }

        return view('hr.application.evaluation-form')
            ->with([
                'segment' => $segmentList,
                'applicationRound' => $applicationRound,
                'employees' => Employee::active()
                    ->orderBy('name')
                    ->get(),
            ])
            ->render();
    }

    public function update($applicationRoundId)
    {
        $request = request()->all();

        $applicationRound = ApplicationRound::find($applicationRoundId);

        if (array_key_exists('evaluation', request()->all())) {
            $applicationRound->updateOrCreateEvaluation(request()->all()['evaluation']);
        }
        if (array_key_exists('evaluation_segment', $request)) {
            $applicationRound->updateOrCreateEvaluationSegment($request['evaluation_segment']);
        }

        return redirect()
            ->back()
            ->with('status', 'Evaluation updated successfully!');
    }

    private function getSegments($applicationId, $round)
    {
        $query = null;
        $telephonicInterviewRound = Round::select('id')->where('name', 'Telephonic Interview')->first();
        if ($telephonicInterviewRound && $telephonicInterviewRound->id == $round->id) {
            $query = Segment::where('round_id', $round->id);
        } else {
            $query = Segment::where('round_id', '!=', $telephonicInterviewRound->id);
        }

        return $query
            ->with([
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
            ])
            ->get();
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
        $evaluationDetails['option'] = $evaluation->evaluationOption ? $evaluation->evaluationOption->value : null;
        $evaluationDetails['marks'] = $evaluation->evaluationOption ? $evaluation->evaluationOption->marks : null;

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
        if ($parameter->slug) {
            $parameterDetails['slug'] = $parameter->slug;
        }
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
}
