<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string',
            'project_id' => 'required|integer',
            'project_invoice_id' => 'required',
            'status' => 'required|string',
            'sent_on' => 'required|date',
            'paid_on' => 'nullable|date',
        ];

        if ($this->method() === 'POST') {
            $rules['invoice_file'] = 'required|file';
        }

        return $rules;
    }
}
