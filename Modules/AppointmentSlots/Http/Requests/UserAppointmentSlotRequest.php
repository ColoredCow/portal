<?php
namespace Modules\AppointmentSlots\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAppointmentSlotRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        if ($this->method() === 'POST') {
            $rules = [
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                'recurrence' => 'required',
                'repeat_till' => 'exclude_if:recurrence,none|required|after:start_time',
                'user_id' => 'required',
            ];
        }

        if ($this->method() === 'PATCH') {
            $rules = [
                'edit_start_time' => 'required|date',
                'edit_end_time' => 'required|date|after:edit_start_time',
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
