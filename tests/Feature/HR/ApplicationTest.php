<?php

namespace Tests\Feature\HR;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\HR\Applicant;
use App\Models\HR\Job;
use App\Models\HR\Round;
use App\Models\Setting;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testApplicationCreated()
    {
        $user = factory(\App\User::class)->create();
        $this->assertTrue(isset($user->id));

        Setting::insert([
            [
                'module' => 'hr',
                'setting_key' => 'applicant_create_autoresponder_subject',
                'setting_value' => 'random stuff for mail subject',
            ],
            [
                'module' => 'hr',
                'setting_key' => 'applicant_create_autoresponder_body',
                'setting_value' => 'random stuff for mail body',
            ]
        ]);

        $round = factory(Round::class)->create();
        $this->assertTrue(isset($round->id));

        $job = factory(Job::class)->create();
        $this->assertTrue(isset($job->id));
        $this->assertTrue($job->rounds->count() == 1);

        $applicantAttr = [
            'name' => 'Taylor Otwell',
            'email' => 'vaibhav@coloredcow.com',
            'phone' => '123321',
            'college' => 'Sample college',
            'graduation_year' => '2018',
            'course' => 'Test Course',
            'linkedin' => 'https://github.com/coloredcow/employee-portal',
            'resume' => 'https://github.com/coloredcow/employee-portal',
            'form_data' => [
                'data 1' => 'Sample content 1',
                'data 2' => 'Sample content 2',
            ],
            'job_title' => $job->title,
        ];

        $applicant = Applicant::_create($applicantAttr);

        $this->assertTrue(isset($applicant->id));
        $this->assertTrue($applicant->email == $applicantAttr['email']);
        $this->assertTrue(isset($applicant->applications));
        $this->assertFalse($applicant->applications->count() > 1);

        $application = $applicant->applications->first();

        $this->assertTrue(isset($application->applicationRounds));
        $this->assertFalse($application->applicationRounds->count() > 1);

    }
}
