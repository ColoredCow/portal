<?php

namespace Modules\HR\Http\Requests\Recruitment;

use Illuminate\Foundation\Http\FormRequest;

class JobDesignationRequest extends FormRequest
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
        return [
            'name' => 'required|unique:hr_job_designation,designation',
            'domain' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Designation name is required',
            'name.unique'  => 'Designation field is already taken',
            'domain.required' => 'Select a domain',
        ];
    }
}
