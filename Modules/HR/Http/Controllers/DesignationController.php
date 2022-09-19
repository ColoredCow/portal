<?php

namespace Modules\HR\Http\Controllers;

use Modules\HR\Http\Requests\Recruitment\JobDesignationRequest;
use Modules\HR\Entities\HrJobDesignation;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;

class DesignationController extends Controller
{

    public function index()
    {
        $designations = HrJobDesignation::all();
        return view('hr.designations.index')->with([
            'designations' => $designations,
        ]);
    }

    public function storeDesignation(JobDesignationRequest $request)
    {
        $jobDesignation = new HrJobDesignation();
        $jobDesignation->designation = $request['name'];
        $jobDesignation->slug = Str::slug($request['name']);
        $jobDesignation->save();

        return redirect()->back();
    }
  
    public function edit(HrJobDesignation $request, $id )
    {
        $HrJobDesignation = $request->find($id);
        return redirect()->back();
    }

    public function destroy(HrJobDesignation $request, $id )
    {
        $HrJobDesignation = $request->find($id);
        $HrJobDesignation->delete();

        return redirect()->back();
    }
}
