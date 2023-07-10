<?php

namespace Modules\CodeTrek\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'topic_name' => 'required|string',
            'link' => 'required|string',
            'date' => 'required|date',
            'summary' => 'required|string|max:250',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'topic_name.required' => 'Please enter the topic name.',
            'link.required' => 'Please enter the session link.',
            'date.required' => 'Please enter the session date.',
            'date.date' => 'Please enter a valid date.',
            'summary.required' => 'Please enter the summary.',
            'summry.max' => "Summary is more than 250 cahracters"
        ];
    }
}
