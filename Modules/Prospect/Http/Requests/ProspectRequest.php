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
            'proposal_sent_date' => 'required',
            'domain' => 'required',
            'customer_type' => 'required',
            'budget' => 'required',
            'proposal_status' => 'required',
            'currency' => 'required',
            'rfp_link' => 'required',
            'proposal_link' => 'required',
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
            'proposal_sent_date.required' => 'Proposal sent date is required',
            'domain.required' => 'Domain is required',
            'customer_type.required' => 'Customer type is required',
            'budget.required' => 'Budget is required',
            'proposal_status.required' => 'Proposal status is required',
            'rfp_url.required' => 'RFP URL is required',
            'proposal_url.required' => 'Proposal URL is required',
        ];
    }
}
