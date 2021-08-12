<?php

namespace Modules\HR\Http\Requests\Recruitment;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
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
                'domain' => 'required|string',
                'description' => 'required|string',
                'type' => 'required|string|in:job,internship,volunteer',
                'status' => 'required|string',
                'by' => 'nullable|string', // Todo: remove this. not needed anymore.
                'link' => 'nullable|url', // Todo: remove this. not needed anymore.
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ];
        }

        if ($this->method() === 'PATCH') {
            $rules = [
                'title' => 'required|string',
                'domain' => 'required|string',
                'description' => 'required|string',
                'type' => 'required|string|in:job,internship,volunteer',
                'status' => 'required|string',
                'facebook_post' => 'nullable|url',
                'instagram_post' => 'nullable|url',
                'twitter_post' => 'nullable|url',
                'linkedin_post' => 'nullable|url',
                'rounds' => 'nullable',
            ];
        }
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
