<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
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
            'name' => 'required|string|unique:roles,name',
			'guard_name' => 'required|string|unique:roles,guard_name',
			'description' => 'required|string|unique:roles,description',
        ];
    }
   
}
