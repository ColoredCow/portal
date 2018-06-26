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
            'admin_email' => 'required|email',
            'gsuite_sa_client_id' => 'required|string',
            'gsuite_dwd_private_key' => 'required|file|mimes:json',
            'slug' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Organization name is required',
            'admin_email.required' => 'Admin email is required',
            'admin_email.email' => 'Admin email should be a valid email address',
            'gsuite_sa_client_id.required' => 'Service account client ID is required',
            'gsuite_dwd_private_key.required' => 'Service account private key is required',
            'gsuite_dwd_private_key.file' => 'Service account private key must be a valid file',
            'gsuite_dwd_private_key.mimes' => 'Service account private key must be a valid JSON file',
            'slug.required' => 'Workspace name is required',
        ];
    }
}
