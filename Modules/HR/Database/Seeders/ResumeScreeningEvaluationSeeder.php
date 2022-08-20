<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\Evaluation\Parameter;
use Modules\HR\Entities\Evaluation\Segment;
use Modules\HR\Entities\Round;

class ResumeScreeningEvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $evaluationParametersList = [

            [
                'name' => 'Resume looks good?',
                'segment_id'=> Segment::create()->id
            ],

             [
               'name' => 'Seems expensive?',
                'segment_id'=> Segment::create()->id
            ],
            [
                'name' => 'Looks ambitious?',
                'segment_id'=> Segment::create()->id
            ],

        ];

        $evaluationParametersOptions = [
            [
                'value' => 'yes',
            ],
            [
                'value' => 'NO',
            ],
        ];

        $round = Round::where('name', 'Resume Screening')->first();

        $round->evaluationParameters()->createMany($evaluationParametersList);

        $evaluationParameters = Parameter::all();

        foreach ($evaluationParameters as $evaluationParameter) {
            $evaluationParameter->options()->createMany($evaluationParametersOptions);
        }
    }
}
