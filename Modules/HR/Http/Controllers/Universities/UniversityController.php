<?php

namespace Modules\HR\Http\Controllers\Universities;

use Illuminate\Routing\Controller;
use Modules\HR\Entities\University;
use Modules\HR\Http\Requests\UniversityRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\HR\Contracts\UniversityServiceContract;
use Illuminate\Support\Facades\DB;

class UniversityController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(UniversityServiceContract $service)
    {
        $this->authorizeResource(University::class);
        $this->service = $service;
    }

    public function index()
    {
        $this->authorize('list', University::class);

        $applications = DB::table('hr_universities')
        ->leftJoin('hr_applicants', 'hr_universities.id', '=', 'hr_applicants.hr_university_id')
        ->leftjoin('hr_universities_contacts', 'hr_universities.id', '=', 'hr_universities_contacts.hr_university_id')
        ->select(
            'hr_universities.*',
            'hr_universities_contacts.name as st_name',
            'hr_universities_contacts.email',
            'hr_universities_contacts.phone',
            'hr_universities_contacts.designation'
        )
        ->orderBy(DB::raw('count(hr_applicants.hr_university_id)'), 'desc')
        ->groupBy('hr_universities.id')
        ->get();
        $searchString = (request()->has('search')) ? request()->input('search') : false;
        $universities = $this->service->list($searchString);

        return view('hr::universities.index')->with([
            'universities' => $universities,
            'applications' => $applications,
        ]);
    }

    public function create()
    {
        return view('hr::universities.create');
    }

    public function store(UniversityRequest $request)
    {
        $university = University::create([
            'name'=>$request['name'],
            'address'=>$request['address'] ?? null,
            'rating'=>$request['rating'] ?? null
        ]);

        return redirect(route('universities.edit', $university))->with('status', 'University created successfully!');
    }

    public function edit(University $university)
    {
        return view('hr::universities.edit')->with([
            'university' => $university,
        ]);
    }

    public function update(UniversityRequest $request, University $university)
    {
        $university->update([
            'name'=>$request['name'],
            'address'=>$request['address'] ?? null,
            'rating'=>$request['rating'] ?? null
        ]);

        return redirect(route('universities.edit', $university))->with('status', 'University updated successfully!');
    }

    public function destroy(University $university)
    {
        $isDeleted = $university->delete();
        $status = $isDeleted ? 'University Deleted successfully!' : 'Something went wrong! Please try again';

        return redirect(route('universities.index'))->with('status', $status);
    }
}
