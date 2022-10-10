<?php

namespace Modules\HR\Services;

use Modules\HR\Http\Requests\Recruitment\JobDesignationRequest;
use Illuminate\Support\Str;
use Modules\HR\Entities\HrJobDesignation;

class HrJobDesignationService
{
    public function index()
    {
        $designations = HrJobDesignation::all();

        return [
            'designations' => $designations,
        ];
    }

    public function storeDesignation(JobDesignationRequest $request)
    {
        $jobDesignation = new HrJobDesignation();
        $jobDesignation->designation = $request['name'];
        $jobDesignation->slug = Str::slug($request['name']);
        $jobDesignation->save();
    }

    public function edit(JobDesignationRequest $request, $id)
    {
        $hrJobDesignation = HrJobDesignation::find($id);

        $hrJobDesignation->designation = $request['name'];
        $hrJobDesignation->slug = Str::slug($request['name']);
        $hrJobDesignation->save();
    }

    public function destroy(HrJobDesignation $request, $id)
    {
        $hrJobDesignation = $request->find($id);
        $hrJobDesignation->delete();
    }
}
