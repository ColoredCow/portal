<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Factory;

class CodeTrekApplicantFactoryRoundDetails extends Factory
{
    protected $model = CodetrekApplicantRoundDetail::class;
    public function definition()
    {
        return [
            'feedback' => 'No'
        ];
    }
}
