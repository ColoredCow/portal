<?php

namespace Modules\Client\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Client\Entities\Client;

class ClientNameExist implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return ! Client::where($attribute, $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A client with that :attribute already exist. Please try another :attribute';
    }
}
