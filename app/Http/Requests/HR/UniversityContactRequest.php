<?php

namespace App\Http\Requests\HR;

use Illuminate\Foundation\Http\FormRequest;

class UniversityContactRequest extends FormRequest
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
        $rules=[];
        if ($this->method() === 'POST') {
            $rules = [
                'name'=>'required|string|min:3|max:255',
                'email'=>'required|string|min:3|max:255|unique:hr_universities_contacts',
                'designation'=>'nullable|string|min:2|max:255',
                'phone' => 'required | numeric | digits:10'
            ];
            return $rules;
        }
        if ($this->method() === 'PUT') {
            $rules= [
                'contact_name'=>'required|string|min:3|max:255',
                'contact_email'=>"required|string|min:3|max:255|unique:hr_universities_contacts,email,{$this->contact->id}",
                'contact_designation'=>'nullable|string|min:2|max:255',
                'contact_phone' => 'required | numeric | digits:10'
            ];
        }
        return $rules;
    }
}
