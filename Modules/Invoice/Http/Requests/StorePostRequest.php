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
        $rules =  [
            'client_id' =>'required',
            'billing_level' => 'required',
            'status' => 'required',
            'currency' => 'required',
            'comments' => 'required',
            'amount' => 'required',
            'gst' =>'required',
            'term' => 'required',
            'sent_on' => 'required',
            'due_on' => 'required',
            'invoice_file' =>'required',
            
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
