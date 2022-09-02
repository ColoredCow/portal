<?php

namespace Modules\HR\Database\Factories;

use Modules\HR\Entities\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class HrApplicationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = array_rand(config('hr.status'));

        if ($status == 'custom-mail') {
            $status = 'sent-for-approval';
        } elseif ($status == 'confirmed') {
            $status = 'onboarded';
        }

        return [
            'hr_applicant_id' => $this->getRandomId()[array_rand($this->getRandomId())],
            'hr_job_id' => $this->getRandomId()[array_rand($this->getRandomId())],
            'resume' => 'https://coloredcow.com/wp-content/uploads/2022/08/sample.pdf',
            'status' => $status
        ];
    }

    private function getRandomId()
    {
        return [
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '10',
        ];
    }
}
