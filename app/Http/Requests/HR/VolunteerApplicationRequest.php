<?php

namespace App\Http\Requests\HR;

use Illuminate\Foundation\Http\FormRequest;

class VolunteerApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'hr_job_id' => 'nullable|exists:hr_jobs,id'
        ];

        if ($this->method() === 'POST') {
            $rules = [
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'nullable|string',
                'resume' => 'required|url',
                'job_title' => 'required|string',
                'college' => 'nullable|string',
                'graduation_year' => 'nullable|numeric',
                'course' => 'nullable|string',
                'linkedin' => 'nullable|url',
                'reason_for_eligibility' => 'nullable|string',
                'form_data' => 'nullable|array'
            ];
        }

        if ($this->method() === 'PATCH') {
            $rules = [
                'round_status' => 'nullable|string',
                'round_id' => 'nullable|integer',
                'reviews' => 'nullable',
            ];
        }
        return $rules;
    }
}
