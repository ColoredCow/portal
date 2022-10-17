<?php

namespace Modules\HR\Services;

use Modules\HR\Http\Requests\Recruitment\JobDesignationRequest;
use Illuminate\Support\Str;
use Modules\HR\Entities\HrJobDesignation;
use Modules\HR\Entities\HrJobDomain;

class HrJobDesignationService
{
    public function index()
    {
        $designations = HrJobDesignation::all();
        $domains = HrJobDomain::all();

        return [
            'designations' => $designations,
            'domains' => $domains,
        ];
    }

    public function storeDesignation(JobDesignationRequest $request)
    {
        $jobDesignation = new HrJobDesignation();
        $jobDesignation->designation = $request['name'];
        $jobDesignation->slug = Str::slug($request['name']);
        $jobDesignation->domain_id = $request['domain'];
        $jobDesignation->save();
    }

    public function edit($id)
    {
        $hrJobDesignation = HrJobDesignation::find($id);
        $hrJobDesignation->designation = request('name');
        $hrJobDesignation->slug = Str::slug(request('name'));
        $hrJobDesignation->domain_id = request('domain');
        $hrJobDesignation->update();
    }

    public function destroy(HrJobDesignation $request, $id)
    {
        $hrJobDesignation = $request->find($id);
        $hrJobDesignation->delete();
    }
}
