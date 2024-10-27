<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TeamMemberDesignationRule implements Rule
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
     *
     * @return bool
     */
    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function passes($attribute, $value)
    {
        foreach ($value as $memberData) {
            if (isset($memberData['designation']) == false) {
                return false;
            }
            if ($memberData['designation'] == null) {
                return false;
            }
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
        return 'Designation Required';
    }
}
