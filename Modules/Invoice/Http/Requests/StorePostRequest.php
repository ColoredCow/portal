<?php

namespace Modules\Invoice\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'client_id' =>'required|integer',
            'billing_level' => 'required|string',
            'status' => 'required|string',
            'currency' => 'required|string',
            'comments' => 'nullable|string',
            'amount' => 'required|numeric',
            'gst' =>'required|numeric',
            'term' => 'required',
            'sent_on' => 'required|date',
            'due_on' => 'required|date',
            'invoice_file' =>'required|mimes:pdf',
        ];

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
