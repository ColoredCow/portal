<?php

namespace App\Http\Controllers\HR\Universities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HR\University;
use App\Http\Requests\HR\UniversityRequest;

class UniversityController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(University::class, null, [
            'except' => ['store'],
        ]);
    }

    public function index()
    {
        $this->authorize('list', University::class);
        $searchString = (request()->has('search')) ? request()->input('search') : false;
        $universities = University::getUniversities($searchString);
        return view('hr.universities.index')->with([
            'universities' => $universities,
        ]);
    }

    public function create()
    {
        return view('hr.universities.create');
    }

    public function store(UniversityRequest $request)
    {
        $validatedData = $request->validated();
        $university=University::create([
            'name'=>$validatedData['name'],
            'address'=>$validatedData['address'] ?? null,
            'rating'=>$validatedData['rating'] ?? null
        ]);
        return $request->wantsJson()?response()->json(['error' => !$university]):redirect(route('universities.edit', $university))->with('status', 'University created successfully!');
    }

    public function edit(University $university)
    {
        return view('hr.universities.edit')->with([
            'university' => $university,
        ]);
    }

    public function update(UniversityRequest $request, University $university)
    {
        $validatedData = $request->validated();
        $updated = $university->update([
            'name'=>$validatedData['name'],
            'address'=>$validatedData['address'] ?? null,
            'rating'=>$validatedData['rating'] ?? null
        ]);
        return redirect(route('universities.edit', $university))->with('status', 'University updated successfully!');
    }

    public function destroy(University $university)
    {
        $isDeleted=$university->delete();
        return $isDeleted?redirect(route('universities'))->with('status', 'University Deleted successfully!'):
        redirect(route('universities'))->with('status', 'Something went wrong! Please try again');
    }

    public function getUniversityList()
    {
        $data=University::all('name', 'id')->toArray();
        return response()->json($data);
    }
}
