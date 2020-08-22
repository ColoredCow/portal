<?php

namespace App\Http\Requests\HR;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UniversityRequest extends FormRequest
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
                'name'=>'required|string|min:3|max:255|unique:hr_universities',
                'address'=>'nullable|string|min:3|max:255',
                'rating'=>'nullable|numeric'
            ];
            return $rules;
        }
        if ($this->method() === 'PUT') {
            $rules= [
                'name'=>"required|string|min:3|max:255|unique:hr_universities,name,{$this->university->id}",
                'address'=>'nullable|string|min:3|max:255',
                'rating'=>'nullable|numeric'
            ];
        }
        return $rules;
        
    }
}
