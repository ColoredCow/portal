<?php

namespace Modules\HR\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniversityAliasRequest extends FormRequest
{
    public function rules()
    {
        $rules = ['name' => 'required|string'];
        switch ($this->method()) {
            case 'POST':
                $rules['hr_university_id'] = 'required|exists:hr_universities,id';
                break;
            default:
                break;
        }

        return $rules;
    }

    public function authorize()
    {
        return true;
    }
}
