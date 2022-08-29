<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
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
            'name' => 'required|string',
            'address' => 'required|string',
            'annual_sales' => 'required|integer',
            'members' => 'required|integer',
            'industry' => 'required|string',
            'email' => 'required|string',
            'billing_details' => 'required|string',
            'website' => 'required|string',
         ];
    }
}
