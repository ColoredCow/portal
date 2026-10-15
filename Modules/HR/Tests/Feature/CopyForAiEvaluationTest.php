<?php

namespace Modules\HR\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Job;
use Tests\TestCase;

class CopyForAiEvaluationTest extends TestCase
{
    use RefreshDatabase;

    public function test_clipboard_text_includes_applied_for_job_title()
    {
        $applicant = Applicant::factory()->create(['name' => 'Jane Doe']);
        $job = Job::factory()->create(['title' => 'Senior Laravel Developer']);
        $application = Application::factory()->create([
            'hr_applicant_id' => $applicant->id,
            'hr_job_id' => $job->id,
        ]);

        $html = view('hr.application.copy-for-ai-evaluation', [
            'applicant' => $applicant,
            'application' => $application,
        ])->render();

        $this->assertStringContainsString('Applied for: ' . $job->title, $html);
    }
}
