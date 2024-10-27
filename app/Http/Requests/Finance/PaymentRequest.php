<?php
namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'invoice_id' => 'required|numeric',
            'paid_at' => 'required|date',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'tds' => 'nullable|string',
            'conversion_rate_diff' => 'nullable|string',
            'bank_charges' => 'nullable|string',
            'bank_service_tax_forex' => 'nullable|string',
            'mode' => 'required|string',
            // 'wire_transfer_via' => 'nullable|string|required_if:mode,wire-transfer',
            'cheque_status' => 'nullable|string|required_if:mode,cheque',
            'cheque_received_on' => 'nullable|string|required_if:cheque_status,received',
            'cheque_cleared_on' => 'nullable|string|required_if:cheque_status,cleared',
            'cheque_bounced_on' => 'nullable|string|required_if:cheque_status,bounced',
        ];
    }
}
