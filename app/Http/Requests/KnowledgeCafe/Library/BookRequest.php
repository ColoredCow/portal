<?php

namespace App\Http\Requests\KnowledgeCafe\Library;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'add_method' => 'filled|string',
            'title' => 'filled|string',
            'author' => 'nullable|string',
            'readable_link' => 'filled|string',
            'categories' => 'nullable',
            'thumbnail' => 'filled|string',
            'isbn' => 'filled|string',
            'self_link' => 'nullable|string',
            'number_of_copies' => 'nullable|integer|gte:1',
            'on_kindle' => 'nullable'
            //'location'  => 'filled|string',
        ];
    }
}
