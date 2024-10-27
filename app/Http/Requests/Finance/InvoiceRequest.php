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
            'currency' => 'required|string',
            'amount' => 'required|numeric',
            'sent_on' => 'required|date',
            'due_on' => 'required|date',
            'gst' => 'nullable|numeric',
            'comments' => 'nullable|string',
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
            'sent_on.required' => 'Sent date is required',
            'due_on.required' => 'Due date is required',
            'amount.numeric' => 'Amount must be a valid decimal',
            'project_invoice_id.required' => 'Invoice ID is required',
            'project_invoice_id.min' => 'Invoice ID must be greater than 0',
            'project_invoice_id.integer' => 'Invoice ID should be a valid number',
            'invoice_file.required' => 'An invoice file needs to be uploaded',
            'billings.required' => 'At least one billing is required',
        ];
    }
}
