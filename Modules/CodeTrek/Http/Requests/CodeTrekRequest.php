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
            'phone' => 'nullable|numeric',
            'github_username' => 'required|string',
            'start_date' => 'required|date',
            'university_name' => 'nullable|string',
            'course' => 'nullable|string',
            'graduation_year' => 'nullable|numeric|digits:4',
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
            'phone.numeric' => 'Please enter a valid phone number.',
            'github_username.required' => 'Please enter your Github username.',
            'start_date.required' => 'Please enter the start date.',
            'start_date.date' => 'Please enter a valid date.',
            'university_name.required' => 'Please enter your university name.',
            'course.required' => 'Please enter your course name.',
            'graduation_year.required' => 'Please enter your graduation year.',
            'graduation_year.numeric' => 'Please enter a valid graduation year.',
            'graduation_year.digits' => 'Graduation year should be in 4 digit format.'
        ];
    }
}
