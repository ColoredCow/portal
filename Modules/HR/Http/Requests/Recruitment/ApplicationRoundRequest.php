<?php

namespace Modules\HR\Http\Requests\Recruitment;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRoundRequest extends FormRequest
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
            'reviews' => 'nullable',
            'action' => 'required|string',
            'refer_to' => 'nullable|string|required_if:action,refer',
            'scheduled_date' => 'nullable|date',
            'scheduled_person_id' => 'nullable|integer',
            'next_round' => 'nullable|string|required_if:action,confirm',
            'create_calendar_event' => 'nullable|filled',
            'summary_calendar_event' => 'nullable|string',
            'next_scheduled_start' => 'nullable|date',
            'next_scheduled_end' => 'nullable|date',
            'next_scheduled_person_id' => 'nullable|integer|required_if:action,confirm',
            'round_evaluation' => 'nullable|array',
            'send_for_approval_person' => 'nullable|integer|required_if:action,send-for-approval',
            'designation' => 'nullable|string|required_if:action,onboard',
            'onboard_email' => 'nullable|string|required_if:action,onboard',
            'onboard_password' => 'nullable|string|required_if:action,onboard',
            'send_mail_to_applicant.confirm' => 'nullable|filled',
            'send_mail_to_applicant.reject' => 'nullable|filled',
            'send_mail_to_applicant.hold' => 'nullable|filled',
            'follow_up_comment_for_reject' => 'nullable|string',
        ];

        if (request()->input('action') == 'confirm') {
            if (request()->input('send_mail_to_applicant.confirm') == 'on') {
                $rules['mail_to_applicant.confirm.subject'] = 'nullable|string|required_with:send_mail_to_applicant';
                $rules['mail_to_applicant.confirm.body'] = 'nullable|string|required_with:send_mail_to_applicant';
            }
        } elseif (request()->input('action') == 'reject') {
            $rules['reject_reason'] = 'nullable|array';
            if (request()->input('send_mail_to_applicant.reject') == 'on') {
                $rules['mail_to_applicant.reject.subject'] = 'nullable|string|required_with:send_mail_to_applicant';
                $rules['mail_to_applicant.reject.body'] = 'nullable|string|required_with:send_mail_to_applicant';
            }
        }

        if (request()->input('action') == 'confirm' && request()->input('create_calendar_event') == 'on') {
            $rules['summary_calendar_event'] = 'nullable|string|required_with:create_calendar_event';
            $rules['next_scheduled_end'] = 'nullable|date|required_with:create_calendar_event';
        }

        if (request()->input('action') == 'approve') {
            $rules['subject'] = 'required|string';
            $rules['body'] = 'required|string';
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
            'next_scheduled_start.required_if' => 'The schedule date for next round is required.',
            'next_scheduled_end.required_with' => 'The end time for the interview is required.',
            'next_scheduled_person_id.required_if' => 'The interviewer for next round is required.',
        ];
    }
}
