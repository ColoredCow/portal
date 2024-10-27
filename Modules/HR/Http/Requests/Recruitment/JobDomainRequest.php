<?php

namespace Modules\HR\Http\Requests\Recruitment;

use Illuminate\Foundation\Http\FormRequest;

class JobDomainRequest extends FormRequest
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
            'name' => 'required|unique:hr_job_domains,domain',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Domain name is required',
            'name.unique'  => 'Domain field is already taken',
        ];
    }
}
