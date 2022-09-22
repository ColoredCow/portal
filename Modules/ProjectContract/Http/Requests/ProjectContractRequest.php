<?php

namespace Modules\ProjectContract\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectContractRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'website_url' => 'required|active_url',
            'logo_img'  => 'required',
            'authority_name' => 'required|string',
            'contract_date_for_signing' => 'required|date',
            'contract_date_for_effective' => 'required|date',
            'contract_expiry_date' => 'required|date',
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
