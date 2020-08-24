<?php

namespace App\Http\Requests\HR;

use Illuminate\Foundation\Http\FormRequest;

class SlotsRequest extends FormRequest
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
        if ($this->method() === 'POST') {
            $rules = [
                'start_time'=>'required|date',
                'end_time'=>'required|date|after:start_time',
                'recurrence'=>'required',
                'repeat_till'=>'required_if:recurrence,weekly,monthly'
            ];
        }

        if ($this->method() === 'PATCH') {
            $rules = [
                'start_time'=>'required|date',
                'end_time'=>'required|date|after:start_time',
            ];
        }
        return $rules;
    }
}
