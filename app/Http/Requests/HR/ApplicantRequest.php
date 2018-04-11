<?php

namespace App\Http\Requests\HR;

use Illuminate\Foundation\Http\FormRequest;

class ApplicantRequest extends FormRequest
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
        if ($this->method() === 'POST')
        {
            $rules = [
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'nullable|string',
                'resume' => 'required|url',
                'job_title' => 'required|string',
                'college' => 'string',
                'graduation_year' => 'numeric',
                'course' => 'string',
                'linkedin' => 'url',
                'reason_for_eligibility' => 'string'
            ];
        }

        if ($this->method() === 'PATCH')
        {
            $rules = [
                'round_status' => 'nullable|string',
                'round_id' => 'nullable|integer',
                'reviews' => 'nullable',
            ];
        }
        return $rules;
    }
}
