<?php

namespace Modules\HR\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaximumSlotRequest extends FormRequest
{
     /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        if ($this->method() === 'POST') {
            $rules = [
                'max_appointments_per_day' => 'required|integer',
                'user_id' => 'required|integer',
            ];
        }

        return $rules;
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