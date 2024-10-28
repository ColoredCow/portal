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
