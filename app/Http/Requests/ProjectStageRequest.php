<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStageRequest extends FormRequest
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
            'project_id' => 'nullable|integer',
            'name' => 'required|string',
            'cost' => 'required|numeric',
            'currency' => 'nullable|string|size:3',
            'cost_include_gst' => 'nullable',
            'billing' => 'nullable',
            'new_billing' => 'nullable',
            'type' => 'required|string',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
        ];
    }
}
