<?php

namespace App\Http\Requests\KnowledgeCafe;

use Illuminate\Foundation\Http\FormRequest;

class WeeklyDoseRequest extends FormRequest
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
            'description' => 'required|string',
            'url' => 'required|url',
            'recommended_by' => 'required|string',
        ];
    }
}
