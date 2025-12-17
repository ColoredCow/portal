<?php

namespace Modules\HR\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniversityContactRequest extends FormRequest
{
    public function rules()
    {
        $rules = [];
        if ($this->method() === 'POST') {
            return [
                'name'=>'required|string',
                'email'=>'required|string',
                'designation'=>'required|string',
                'phone' => 'required | numeric | digits:10',
                'hr_university_id'=>'required|exists:hr_universities,id',
            ];
        }
        if ($this->method() === 'PUT') {
            $rules = [
                'name'=>'required|string',
                'email'=>'required|string',
                'designation'=>'required|string',
                'phone' => 'required | numeric | digits:10',
            ];
        }

        return $rules;
    }

    public function authorize()
    {
        return true;
    }
}
