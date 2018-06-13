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
            'project_invoice_id' => 'required|integer|min:1',
            'status' => 'required|string',
            'sent_on' => 'required',
            'sent_amount' => 'required|numeric',
            'currency_sent_amount' => 'required|string|size:3',
            'paid_on' => 'nullable',
            'paid_amount' => 'nullable|numeric',
            'payment_type' => 'nullable|string',
            'cheque_status' => 'nullable|string|required_if:payment_type,cheque',
            'cheque_received_date' => 'nullable|string',
            'cheque_cleared_date' => 'nullable|string',
            'cheque_bounced_date' => 'nullable|string',
            'currency_paid_amount' => 'nullable|string|size:3',
            'comments' => 'nullable|string',
            'tds' => 'nullable|numeric',
            'currency_tds' => 'nullable|string|size:3',
            'conversion_rate' => 'nullable|numeric',
            'transaction_charge' => 'nullable|numeric',
            'currency_transaction_charge' => 'nullable|string',
            'transaction_tax' => 'nullable|numeric',
            'currency_transaction_tax' => 'nullable|string',
            'billings' => 'required',
            'gst' => 'nullable|numeric',
            'request_from_billing' => 'nullable|boolean',
            'due_amount' => 'nullable|numeric',
            'currency_due_amount' => 'nullable|string',
            'due_date' => 'required',

        ];

        if ($this->method() === 'POST') {
            $rules['invoice_file'] = 'required|file';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'project_ids.required' => 'At least one project is required',
            'sent_on.required' => 'Invoice sent date is required',
            'sent_amount.numeric' => 'Invoice amount must be a valid decimal',
            'paid_amount.numeric' => 'Received amount must be a valid decimal',
            'project_invoice_id.required' => 'Invoice ID is required',
            'project_invoice_id.min' => 'Invoice ID must be greater than 0',
            'project_invoice_id.integer' => 'Invoice ID should be a valid number',
            'invoice_file.required' => 'An invoice needs to be uploaded',
            'billings.required' => 'At least one billing is required',
        ];
    }
}
