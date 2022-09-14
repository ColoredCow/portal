<?php

namespace Modules\Revenue\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RevenueProceedRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'currency' => 'required|string',
            'amount' => 'required|integer',
            'category' => 'nullable|integer',
            'notes' => 'nullable|integer',
            'recieved_at' => 'nullable|date',
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
