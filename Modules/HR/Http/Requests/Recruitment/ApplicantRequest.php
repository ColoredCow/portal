<?php

namespace Modules\HR\Http\Requests\Recruitment;

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
        $rules = [
            'hr_job_id' => 'nullable|exists:hr_jobs,id',
        ];

        if ($this->method() === 'POST') {
            $rules = [
                'opportunity_id' => 'required|numeric',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'nullable|string',
                'wa_optin_at' => 'nullable|date_format:Y-m-d\TH:i',
                'college' => 'nullable|string',
                'graduation_year' => 'nullable|numeric',
                'course' => 'nullable|string',
                'linkedin' => 'nullable|string',
                'resume' => 'nullable|url',
                'resume_file' => 'nullable|file',
                'form_data' => 'nullable|array',
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
