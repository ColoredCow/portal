<?php

namespace Modules\HR\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileEditRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|regex:/^[a-zA-Z ]+$/',
            'nickName' => 'required|regex:/^[a-zA-Z ]+$/',
            'designation' => 'required|regex:/^[a-zA-Z ]+$/',
            'domainId' => 'exists:hr_job_domains,id'
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'Name should contain only alphabets !',
            'nickName.regex' => 'Nick name should contain only alphabets !',
            'designation.regex' =>'Designation should contain only alphabets !'
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