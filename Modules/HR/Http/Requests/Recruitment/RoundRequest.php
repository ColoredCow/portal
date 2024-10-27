<?php

namespace Modules\HR\Http\Requests\Recruitment;

use Illuminate\Foundation\Http\FormRequest;

class RoundRequest extends FormRequest
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
            'name' => 'nullable|string',
            'type' => 'required|string',
            'guidelines' => 'nullable|string|required_if:type,guidelines',
            'round_mail_subject' => 'nullable|string',
            'round_mail_body' => 'nullable|string',
        ];
    }
}
