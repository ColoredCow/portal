<?php

namespace Modules\Project\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Project\Entities\Project;

class ProjectNameExist implements Rule
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
        return ! (Project::where($attribute, $value)->exists());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A project with that :attribute already exist. Please try another :attribute';
    }
}
