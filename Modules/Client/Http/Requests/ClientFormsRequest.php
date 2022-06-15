<?php

namespace Modules\Client\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientFormsRequest extends FormRequest
{
    private function clientDetailsValidation()
    {
        $rules = [
            'name' => 'required|string',
            'is_channel_partner' => 'nullable|string',
            'channel_partner_id' => 'nullable|string',
            'parent_organisation_id' => 'nullable|string',
        ];

        if (request()->has('status')) {
            $rules['status'] = 'required|string|in:inactive';
        }

        return $rules;
    }

    private function contactPersonsValidation()
    {
        return [
            'client_contact_persons.*.name' => 'nullable|max:120',
            'client_contact_persons.*.email' => 'required|email',
            'client_contact_persons.*.phone' => 'nullable|digits_between:4,10|integer',
        ];
    }

    private function addressValidation()
    {
        return [
            'address.*.country_id' => 'required|string',
            'address.*.address' => 'required|string',
            'address.*.state' => 'nullable|string',
            'address.*.gst_number' => 'nullable|string',
            'address.*.city' => 'nullable|string',
            'address.*.area_code' => 'nullable|string',
        ];
    }

    private function billingDetailsValidation()
    {
        return [
            'key_account_manager_id' => 'required|string',
            'service_rates' => 'nullable|string',
            'service_rate_term' => 'nullable|string',
            'discount_rate' => 'nullable|string',
            'discount_rate_term' => 'nullable|string',
            'billing_frequency' => 'nullable|string',
            'bank_charges' => 'nullable|string',
        ];
    }

    public function getClientDetailsFormRules()
    {
        $section = $this->all()['section'];
        switch ($section) {
            case 'client-details':
                return $this->clientDetailsValidation();

            case 'contact-persons':
                return $this->contactPersonsValidation();

            case 'address':
                return $this->addressValidation();

            case 'billing-details':
                return $this->billingDetailsValidation();

            case 'default':
                return [];
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getClientDetailsFormRules();
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

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'client_contact_persons.*.phone.*' => 'Please enter a valid phone number.',
            'client_contact_persons.*.email.*' => 'Please enter a valid mailing-address.',
        ];
    }
}
