<?php

namespace Modules\Expense\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class recurringExpenseRequest extends FormRequest
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
            'frequency' => 'required|integer',
            'initial_due_date' => 'required',
            'currency' =>  'required|integer',
            'amount' => 'required|integer',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'name is required',
             'amount.required'=>'amount is required',
             'currency.required'=>'currency is required',
             'frequency.required'=>'frequency is required',
        ];
    }
}