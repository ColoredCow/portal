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
        $request = $this->create_project ?? $this->update_section;

        switch ($request) {
            case 'project_details':
                $rules = [
                    'name' => 'required|string',
                    'client_id' => 'required|integer',
                    'status' => 'required|string',
                    'project_manager' => 'nullable|string',
                    'effort_sheet_url' => 'nullable|active_url|max:191',
                    'project_type' => 'required|string|in:monthly-billing,fixed-budget',
                    'total_estimated_hours' => 'nullable|numeric|between:0,9999.99',
                    'monthly_estimated_hours' => 'nullable|numeric|between:0,9999.99',
                ];
                break;

            case 'create_project':
                $rules = [
                    'name' => 'required|string|unique:projects',
                    'client_id' => 'required|integer',
                    'project_manager' => 'nullable|string',
                    'effort_sheet_url' => 'nullable|active_url|max:191',
                    'project_type' => 'required|string|in:monthly-billing,fixed-budget',
                    'total_estimated_hours' => 'nullable|numeric|between:0,9999.99',
                    'monthly_estimated_hours' => 'nullable|numeric|between:0,9999.99',
                    'contract_file' => 'required|mimes:pdf',
                ];
                break;

            case 'project_team_members':
                if ($this->project_team_member) {
                    $rules = [
                        'project_team_member' => 'array',
                    ];
                }
                break;

            case 'project_repository':
                if ($this->url) {
                    $rules = [
                        'url' => 'array',
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
            'effort_sheet_url.active_url' => 'Effortsheet url is not valid',
            'type.required' => 'Project type is required',
        ];
    }
}
