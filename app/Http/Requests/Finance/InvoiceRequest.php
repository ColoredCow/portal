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
            // invoice fields
            'project_invoice_id' => 'required|integer|min:1',
            // 'status' => 'required|string',
            'invoice_currency' => 'required|string',
            'invoice_amount' => 'required|numeric',
            'sent_on' => 'required|string', // change type to date
            'due_on' => 'nullable|string', // change type to date
            'gst' => 'nullable|numeric',
            'comments' => 'nullable|string',

            // payment fields
            'paid_at' => 'nullable|required_if:status,paid', // add date type
            'payment_amount' => 'nullable|numeric|required_if:status,paid',
            'payment_currency' => 'required|string',
            'tds' => 'nullable|numeric',
            'conversion_rate' => 'nullable|numeric',
            'bank_charges' => 'nullable|numeric',
            'bank_service_tax_forex' => 'nullable|numeric',

            'payment_mode' => 'nullable|string',

            'wire_transfer_via' => 'nullable|string',

            'cheque_status' => 'nullable|string|required_if:payment_mode,cheque',
            'cheque_received_on' => 'nullable|string|required_if:cheque_status,received',
            'cheque_cleared_on' => 'nullable|string|required_if:cheque_status,cleared',
            'cheque_bounced_on' => 'nullable|string|required_if:cheque_status,bounced',

            'billings' => 'required',

            'request_from_billing' => 'nullable|boolean',
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
            'sent_on.required' => 'Invoice sent date is required',
            'invoice_amount.numeric' => 'Invoice amount must be a valid decimal',
            'payment_amount.numeric' => 'Received amount must be a valid decimal',
            'project_invoice_id.required' => 'Invoice ID is required',
            'project_invoice_id.min' => 'Invoice ID must be greater than 0',
            'project_invoice_id.integer' => 'Invoice ID should be a valid number',
            'invoice_file.required' => 'An invoice needs to be uploaded',
            'billings.required' => 'At least one billing is required',
        ];
    }
}
