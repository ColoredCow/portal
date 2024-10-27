<?php
namespace Modules\EffortTracking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'worked_on' => 'required|date',
            'type' => 'required',
            'asignee_id' => 'required',
            'project_id' => 'required',
            'estimated_effort' => 'required',
            'effort_spent' => 'required',
            'comment' => '',
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
