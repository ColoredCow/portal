<?php

namespace Modules\Project\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectContract;

class ProjectContractFactory extends Factory
{
    protected $model = ProjectContract::class;

    public function definition()
    {
        return [
            'project_id' => function () {
                return Project::factory()->create()->id;
            },
            'contract_file_path' => 'contracts/' . $this->faker->uuid . '.pdf',
        ];
    }
}
