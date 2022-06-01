<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TeamMemberRule implements Rule
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
        foreach ($value as $memberExist) {
            if (isset($memberExist['team_member_id']) == false) {
                return false;
            }
            elseif ($memberExist['team_member_id'] == null) {
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
        return 'Team Member Required';
    }
}
