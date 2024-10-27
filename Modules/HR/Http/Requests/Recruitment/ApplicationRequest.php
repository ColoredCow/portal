<?php

namespace Modules\HR\Http\Requests\Recruitment;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
            'action' => 'required|string',
            'hr_job_id' => 'nullable|integer|required_if:action,' . config('constants.hr.application-meta.keys.change-job'),
            'job_change_mail_subject' => 'nullable|string|required_if:action,' . config('constants.hr.application-meta.keys.change-job'),
            'job_change_mail_body' => 'nullable|string|required_if:action,' . config('constants.hr.application-meta.keys.change-job'),
            'application_round_id' => 'nullable|integer|required_if:action,' . config('constants.hr.application-meta.keys.no-show'),
            'no_show_reason' => 'nullable|string|required_if:action,' . config('constants.hr.application-meta.keys.no-show'),
            'no_show_mail_subject' => 'nullable|string|required_if:action,' . config('constants.hr.application-meta.keys.no-show'),
            'no_show_mail_body' => 'nullable|string|required_if:action,' . config('constants.hr.application-meta.keys.no-show'),
        ];
    }
}
