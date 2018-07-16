<?php

namespace Tests\Feature\HR;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTest;
use App\Models\HR\Job;
use App\Models\HR\Applicant;


class VolunteerApplicationsTest extends FeatureTest
{
    
    /** @test */
    public function a_user_can_create_a_volunteer_application() {
        $this->withoutExceptionHandling();
        $this->signIn();
        $data = $this->getVolunteerApplicationData();
        $this->post(route('volunteer.applications.store'), $data)
            ->assertSee($data['name']);
    }


    public function getVolunteerApplicationData($overrides = []) {
        $faker = \Faker\Factory::create();

        $job = create(Job::class, ['type' => config('constants.hr.opportunities.volunteer.type')]);
        $applicant = create(Applicant::class);
        $data =  $applicant->toArray();
        $data['job_title'] = $job->title;
        $data['place'] = $faker->state;
        $data['resume'] = $faker->url;
        $data['form_data'] = [
            'Why do you want to volunteer?' => "Lorem ipsum dolor sit amet"
        ];
        return array_merge($data, $overrides);
    }
}
