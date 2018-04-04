<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'name' => 'required|string',
            'client_id' => 'required|integer',
            'client_project_id' => 'required|integer',
            'status' => 'required|string',
            'started_on' => 'nullable',
            'invoice_email' => 'nullable|email',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'client_project_id.required' => 'Project ID is required',
            'client_project_id.integer' => 'Project ID should be a valid integer value.',
        ];
    }
}
