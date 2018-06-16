<?php

namespace Tests\Feature\HR;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\HR\Applicant;
use App\Models\HR\Job;
use App\Models\HR\Round;
use App\Models\Setting;
use App\User;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Case to test the application creation and other related entities.
     *
     * @return void
     */
    public function testApplicationWorkflow()
    {
        $user = factory(User::class)->create();
        $this->assertTrue(isset($user->id));

        factory(Setting::class)->create([
            'module' => 'hr',
            'setting_key' => 'applicant_create_autoresponder_subject',
        ]);
        factory(Setting::class)->create([
            'module' => 'hr',
            'setting_key' => 'applicant_create_autoresponder_body',
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
