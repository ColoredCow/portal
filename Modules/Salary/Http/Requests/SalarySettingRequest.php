<?php

namespace Modules\Salary\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalarySettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'basic_salary' => 'array',
            'hra' => 'array',
            'employee_esi' => 'array',
            'employer_esi' => 'array',
            'employee_epf' => 'array',
            'employer_epf' => 'array',
            'administration_charges' => 'array',
            'edli_charges' => 'array',
            'transport_allowance' => 'nullable|string',
            'food_allowance' => 'nullable|string',
            'employee_esi_limit' => 'nullable|string',
            'edli_charges_limit' => 'nullable|string',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
