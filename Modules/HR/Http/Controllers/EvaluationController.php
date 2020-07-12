<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\HR\Evaluation\Segment;
use App\Models\HR\Evaluation\Parameter;
use App\Models\HR\Evaluation\ParameterOption;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
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
     * @return Response
     */
    public function segmentParameters(Request $request, $segmentID)
    {
        $segment = Segment::find($segmentID);
        return view('hr::evaluation.segment-parameters', [
            'segment' => $segment,
            'parameters' => $segment->parameters()->with('options')->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function createSegment(Request $request)
    {
        $segment = Segment::create(['name' => $request->name]);
        return redirect(route('hr.evaluation'));
    }

    /**
     * Display a listing of the resource.
     * @return Response
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
}
