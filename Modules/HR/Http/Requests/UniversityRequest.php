<?php
namespace Modules\HR\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniversityRequest extends FormRequest
{
    public function rules()
    {
        $rules = [];
        if ($this->method() === 'POST') {
            return [
                'name'=>'required|string|unique:hr_universities',
                'address'=>'nullable|string',
                'rating'=>'nullable|numeric',
            ];
        }
        if ($this->method() === 'PUT') {
            $rules = [
                'name'=>"required|string|unique:hr_universities,name,{$this->university->id}",
                'address'=>'nullable|string',
                'rating'=>'nullable|numeric',
            ];
        }

        return $rules;
    }

    public function authorize()
    {
        return true;
    }
}
