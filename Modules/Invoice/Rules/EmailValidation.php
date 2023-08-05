<?php

namespace Modules\Invoice\Rules;

use Illuminate\Contracts\Validation\Rule;
use Validator;

class EmailValidation implements Rule
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
     * @param  mixed  $values
     *
     * @return bool
     */
    public function passes($attribute, $values)
    {
        $validator = [];
        $validate = preg_split('/[,]/', $values);
        foreach ($validate as $index=>$value) {
            $validator = Validator::make(['email' => $value], [
                    'email'=> 'email:rfc,dns',
                ]);
        }
        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The cc email not valid.';
    }
}
