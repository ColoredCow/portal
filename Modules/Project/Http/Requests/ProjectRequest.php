<?php

namespace Modules\Project\Http\Requests;

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
        $rules = [];
        switch ($this->update_section) {
            case 'project_details':
                $rules = [
                    'name' => 'required|string',
                    'client_id' => 'required|integer',
                    'status' => 'sometimes|string',
                    'project_manager' => 'nullable|string',
                    'effort_sheet_url' => 'nullable|active_url|max:191',
                ];
                break;

            case 'project_resources':
                if ($this->project_resource) {
                    $rules = [
                        'project_resource' => 'array'
                    ];
                }
                break;

            case 'project_repository':
                if ($this->url) {
                    $rules = [
                        'url' => 'array'
                    ];
                }
        }

        return $rules;
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
            'client_project_id.integer' => 'Project ID should be a valid number',
            'invoice_email.email' => 'Email for invoice should a valid email address',
            'effort_sheet_url.max' => 'Url must be less than 191 characters',
            'effort_sheet_url.active_url' => 'Effortsheet url is not valid'
        ];
    }
}
