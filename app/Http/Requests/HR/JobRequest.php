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
                'type' => 'required|string|in:job,internship,volunteer',
                'by' => 'nullable|string', // Todo: remove this. not needed anymore.
                'link' => 'nullable|url', // Todo: remove this. not needed anymore.
            ];
        }

        if ($this->method() === 'PATCH') {
            $rules = [
                'facebook_post' => 'nullable|url',
                'instagram_post' => 'nullable|url',
                'twitter_post' => 'nullable|url',
                'linkedin_post' => 'nullable|url',
                'rounds' => 'nullable',
                'description' => 'nullable|string',
            ];
        }
        return $rules;
    }
}
