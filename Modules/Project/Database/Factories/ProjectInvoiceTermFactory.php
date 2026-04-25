<?php

namespace Modules\Project\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectInvoiceTerm;

class ProjectInvoiceTermFactory extends Factory
{
    protected $model = ProjectInvoiceTerm::class;

    public function definition()
    {
        return [
            'project_id' => function () {
                return Project::factory()->create()->id;
            },
            'invoice_date' => now()->addMonth()->toDateString(),
            'amount' => 1000.00,
            'status' => 'sent',
            'client_acceptance_required' => false,
            'is_accepted' => false,
            'report_required' => true,
            'delivery_report' => 'delivery_report/2026/04/sample.pdf',
        ];
    }
}
