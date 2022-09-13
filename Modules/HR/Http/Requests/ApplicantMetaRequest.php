<?php

namespace Modules\HR\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicantMetaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'preferred_name' => 'required|string',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'current_address' => 'required|string',
            'permanent_address' => 'required|string',
            'emergency_contact_number' => 'required|integer',
            'blood_group' => 'required|string',
            'illness' => 'required|string',
            'head_shot_image' => 'required|mimes:jpg,jpeg,png',
            'aadhar_card_number' => 'required|integer',
            'aadhar_card_scanned' => 'required|mimes:jpg,jpeg,png',
            'pan_card_number' => 'required|integer',
            'scanned_copy_pan_card' => 'required|mimes:jpg,jpeg,png',
            'acc_holder_name' => 'required|string',
            'bank_name' => 'required|string',
            'acc_number' => 'required|integer',
            'ifsc_code' => 'required|integer',
            'passbook_first_page_img' => 'required|mimes:jpg,jpeg,png',
            'uan_number' => 'required|integer',
            'hr_applicant_id' => 'required|integer',
        ];
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
