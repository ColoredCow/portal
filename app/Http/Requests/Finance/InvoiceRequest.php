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
            'project_id' => 'required|integer',
            'project_invoice_id' => 'required',
            'status' => 'required|string',
            'sent_on' => 'required',
            'sent_amount' => 'required|numeric',
            'currency_sent_amount' => 'required|string|size:3',
            'paid_on' => 'nullable',
            'paid_amount' => 'nullable|numeric',
            'currency_paid_amount' => 'nullable|string|size:3',
            'comments' => 'nullable|string',
        ];

        if ($this->method() === 'POST') {
            $rules['invoice_file'] = 'required|file';
        }

        return $rules;
    }
}
