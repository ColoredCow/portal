<?php

namespace Modules\Client\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
                'name' => 'required|string',
                'initials' => 'required|string',
                'currency' => 'required|string',
                'currency_symbol' => 'nullable',
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
