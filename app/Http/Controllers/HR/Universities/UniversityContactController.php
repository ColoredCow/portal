<?php

namespace App\Http\Controllers\HR\Universities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HR\University;
use App\Models\HR\UniversityContact;
use App\Http\Requests\HR\UniversityContactRequest;

class UniversityContactController extends Controller
{
    public function store(UniversityContactRequest $request, University $university)
    {
        $validatedData = $request->validated();
        UniversityContact::create([
            'name'=>isset($validatedData['name'])?$validatedData['name']:null,
            'email'=>isset($validatedData['email'])?$validatedData['email']:null,
            'designation'=>isset($validatedData['designation'])?$validatedData['designation']:null,
            'phone'=>isset($validatedData['phone'])?$validatedData['phone']:null,
            'hr_university_id'=>$university->id
        ]);
        return redirect(route('universities.edit', $university))->with('status', 'Contact created successfully!');
    }

    public function update($university, UniversityContact $contact, UniversityContactRequest $request)
    {
        $validatedData = $request->validated();
        $updated=$contact->update([
            'name'=>isset($validatedData['contact_name'])?$validatedData['contact_name']:null,
            'email'=>isset($validatedData['contact_email'])?$validatedData['contact_email']:null,
            'designation'=>isset($validatedData['contact_designation'])?$validatedData['contact_designation']:null,
            'phone'=>isset($validatedData['contact_phone'])?$validatedData['contact_phone']:null,
        ]);
        return redirect(route('universities.edit', $university))->with('status', 'Contact updated successfully!');
    }

    public function destroy($university, UniversityContact $contact)
    {
        $isDeleted=$contact->delete();
        return $isDeleted?redirect(route('universities.edit', $university))->with('status', 'Contact Deleted successfully!'):
        redirect(route('universities.edit', $university))->with('status', 'Something went wrong! Please try again');
    }
}
