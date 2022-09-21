<?php

namespace App\Http\Controllers\HR\Volunteers;
//use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Modules\HR\Entities\Job;
//use Illuminate\Support\Facades\Request;
use Modules\HR\Http\Controllers\Recruitment\JobController;

class VolunteerOpportunityController extends JobController
{
    public function getOpportunityType()
    {
        return 'volunteer';
    }

    public function AddUser()
    {
        return view('addUser');
        //dd('hey');
        /*$newUser = new Job;
        
        $newUser->title = 'Weaponslol Specialists';
        $newUser->description = 'Temporibus ea quaerat';
        $newUser->type = 'volunteer';
        $newUser->domain = 'engineering';
        $newUser->status = 'published';
        $newUser->resources_required = '0';
        */
    }

    public function SaveItem(Request $request)
    {
        //dd('hey');
        /*$newUser = new Job;
        $newUser->title = $request->input('title');
        $newUser->description = $request->input('description');
        $newUser->type = $request->input('type');
        $newUser->domain = $request->input('domain');
        */
        $validated = $request->all();
        $volunteer = Job::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'domain' => $validated['domain']
            
        ]);
        return redirect("/hr/applications/volunteer")->with('status', 'Volunteer added succesfully!');


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('list', Job::class);

        $jobs = Job::with([
            'applications' => function ($query) {
                $query->isOpen()->get();
            }])
            ->typeVolunteer()
            ->latest()
            ->paginate(config('constants.pagination_size'))
            ->appends(Request::except('page'));

        return view('hr.job.index')->with([
            'jobs' => $jobs,
            'type' => 'volunteer',
        ]);
    }
}
