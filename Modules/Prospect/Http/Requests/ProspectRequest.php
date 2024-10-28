<?php

namespace Modules\Prospect\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProspectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'org_name' => 'required',
            'poc_user_id' => 'required',
            'proposal_sent_date' => 'nullable|date',
            'domain' => 'nullable',
            'customer_type' => 'nullable',
            'budget' => 'nullable',
            'proposal_status' => 'nullable',
            'introductory_call' => 'nullable',
            'last_followup_date' => 'nullable|date',
            'rfp_link' => 'nullable|url',
            'proposal_link' => 'nullable|url',
            'currency' => 'nullable',
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

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'org_name.required' => 'Organization name is required',
            'poc_user_id.required' => 'Point of contact user ID is required',
        ];
    }
}
