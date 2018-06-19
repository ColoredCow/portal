<?php

namespace App\Http\Requests\HR;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
        if ($this->method() === 'POST') {
            $rules = [
                'title' => 'required|string',
                'by' => 'required|string',
                'link' => 'required|url',
            ];
        }

        if ($this->method() === 'PATCH') {
            $rules = [
                'facebook_post' => 'nullable|url',
                'instagram_post' => 'nullable|url',
                'twitter_post' => 'nullable|url',
                'linkedin_post' => 'nullable|url',
                'rounds' => 'nullable',
            ];
        }
        return $rules;
    }
}
