<?php

namespace Modules\Invoice\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceValidatorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules=[
            'from'=>'required|email',
            'to_name'=>'required',
            'to' => 'required|email',
            'bcc' => 'required|email',
            'cc' => 'required|email',
            'email_subject' => 'required|string',
            'email_body' => 'required|string'
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
    public function messages()
    {
        return [
            'from.required' => 'A sender is required',
            'to.required' => 'The receiver is required',
           'to_name.required'=>'Receivers name must be required',
            'bcc.required' => 'The bcc field is required',
            'bcc.email' => 'An email format in bcc field is required',
            'cc.required' => 'The cc field is required',
            'email_subject.required' => 'A subject field is required',
            'email_subject.string' => 'A string is required',
            'email_body.required' => 'A body field is required',
         ];
    }
}
