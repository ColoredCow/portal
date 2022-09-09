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
             'client_name' => 'string|required|exists:clients,name',
             'website_url' => 'active_url|max:191|required',
             'logo_img'  => 'required|mimes:png,jpg,jpeg',
             'authority_name' => 'nullable|string',
             'contract_date_for_signing' => 'nullable|date',
             'contract_date_for_effective' => 'nullable|date',
             'contract_expiry_date' => 'nullable|date',
             'attributes' => 'array|required',
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
