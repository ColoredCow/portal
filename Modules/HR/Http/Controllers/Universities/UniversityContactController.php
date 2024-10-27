<?php
namespace Modules\HR\Http\Controllers\Universities;

use Illuminate\Routing\Controller;
use Modules\HR\Entities\UniversityContact;
use Modules\HR\Http\Requests\UniversityContactRequest;

class UniversityContactController extends Controller
{
    public function store(UniversityContactRequest $request)
    {
        $contact = UniversityContact::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'designation'=>$request['designation'] ?? null,
            'phone'=>$request['phone'] ?? null,
            'hr_university_id'=>$request['hr_university_id'],
        ]);

        return response()->json(['message'=>'Contact created successfully', 'data' => $contact], 200);
    }

    public function update(UniversityContactRequest $request, UniversityContact $contact)
    {
        $contact->update([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'designation'=>$request['designation'] ?? null,
            'phone'=>$request['phone'] ?? null,
        ]);

        return response()->json(['message'=>'Contact updated successfully', 'data' => $contact], 200);
    }

    public function destroy(UniversityContact $contact)
    {
        $isDeleted = $contact->delete();
        $status = $isDeleted ? 'Contact Deleted successfully!' : 'Something went wrong! Please try again';

        return response()->json(['message'=>$status], 200);
    }
}
