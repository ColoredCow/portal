<?php

namespace Modules\CodeTrek\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CodeTrekRequest extends FormRequest
{
    private function codeTrekValidation()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email_id' => 'required|email',
            'phone' => 'nullable|numeric|digits:10|min:10',
            'github_username' => 'required|string',
            'start_date' => 'required|date',
            'university_name' => 'nullable|string',
            'course' => 'nullable|string',
            'graduation_year' => 'nullable|numeric|digits:4',
            'centre' => 'required|exists:office_locations,id',
            'mentorId' => 'required|exists:users,id',
            'domain' => 'required|in:' . implode(',', array_keys(config('codetrek.domain'))),
        ];
    }

    public function rules()
    {
        return $this->codeTrekValidation();
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'email_id.required' => 'Please enter your email id.',
            'email_id.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter your phone number.',
            'phone.numeric' => 'Please enter a valid 10 digit phone number.',
            'phone.digits' => 'Phone number should be 10 digits.Please recheck',
            'github_username.required' => 'Please enter your Github username.',
            'start_date.required' => 'Please enter the start date.',
            'start_date.date' => 'Please enter a valid date.',
            'university_name.string' => 'University name should be a string.',
            'course.string' => 'Course name should be a string.',
            'graduation_year.numeric' => 'Please enter a valid graduation year.',
            'graduation_year.digits' => 'Graduation year should be in 4 digit format.',
            'centre.required' => 'Please select Centre Name.',
            'centre.exists' => 'Invalid Centre selected.',
            'mentorId.required' => 'Please select Assign Mentor.',
            'mentorId.exists' => 'Invalid Mentor selected.',
            'domain.required' => 'Please select Domain Name.',
            'domain.in' => 'Invalid Domain selected.',
        ];
    }
}
