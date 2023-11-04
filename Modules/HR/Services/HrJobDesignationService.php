<?php

namespace Modules\HR\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\HR\Entities\HrJobDesignation;
use Modules\HR\Entities\HrJobDomain;
use Modules\HR\Http\Requests\Recruitment\JobDesignationRequest;

class HrJobDesignationService
{
    public function index(Request $request)
    {
        $searchDesignation = $request->input('search');
        $designationfilter = HrJobDesignation::where('designation', 'LIKE', $searchDesignation)->get();
        if ($searchDesignation == null) {
            $designations = HrJobDesignation::all();
        } else {
            $designations = $designationfilter;
        }
        $domains = HrJobDomain::all();

        return [
            'designations' => $designations,
            'domains' => $domains,
        ];
    }

    public function storeDesignation(JobDesignationRequest $request)
    {
        $jobDesignation = new HrJobDesignation();
        $jobDesignation->designation = $request['designation'];
        $jobDesignation->slug = Str::slug($request['designation']);
        $jobDesignation->domain_id = $request['domain'];
        $jobDesignation->save();
    }

    public function edit($id, Request $request)
    {
        $hrJobDesignation = HrJobDesignation::find($id);
        $hrJobDesignation->designation = $request['designation'];
        $hrJobDesignation->slug = Str::slug($request['designation']);
        $hrJobDesignation->domain_id = $request['domain'];
        $hrJobDesignation->update();
    }

    public function destroy(HrJobDesignation $request, $id)
    {
        $hrJobDesignation = $request->find($id);
        $hrJobDesignation->delete();
    }
}
