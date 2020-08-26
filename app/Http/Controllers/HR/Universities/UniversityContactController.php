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
            'name'=>$validatedData['name'],
            'email'=>$validatedData['email'],
            'designation'=>$validatedData['designation']??null,
            'phone'=>$validatedData['phone']??null,
            'hr_university_id'=>$university->id
        ]);
        return redirect(route('universities.edit', $university))->with('status', 'Contact created successfully!');
    }

    public function update(UniversityContact $contact, UniversityContactRequest $request)
    {
        $validatedData = $request->validated();
        $updated=$contact->update([
            'name'=>$validatedData['contact_name'],
            'email'=>$validatedData['contact_email'],
            'designation'=>$validatedData['contact_designation']??null,
            'phone'=>$validatedData['contact_phone']??null,
        ]);
        return redirect(route('universities.edit', $contact->university))->with('status', 'Contact updated successfully!');
    }

    public function destroy(UniversityContact $contact)
    {
        $university = $contact->university;
        $isDeleted=$contact->delete();
        return $isDeleted?redirect(route('universities.edit', $university))->with('status', 'Contact Deleted successfully!'):
        redirect(route('universities.edit', $university))->with('status', 'Something went wrong! Please try again');
    }
}
