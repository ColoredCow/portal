<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\Evaluation\Parameter;
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
        if (! app()->environment('production')) {
            $evaluationParametersList = [

                [
                    'id' => 1,
                    'name' => 'Resume looks good?',
                    'segment_id' => 1,
                    'marks' => 1
                ],

                 [
                    'id' => 2,
                    'name' => 'Seems expensive?',
                    'segment_id' => 1,
                    'marks' => 1,
                    'parent_id' => 1
                ],

                [
                    'id' => 3,
                    'name' => 'Looks ambitious?',
                    'segment_id' => 1,
                    'marks' => 1,
                    'parent_id' => 1

                ],

                [
                    'id' => 4,
                    'name' => 'Proceed to next round?',
                    'segment_id' => 1,
                    'marks' => 1,
                    'parent_id' => 1

                ],

                [
                    'id' => 5,
                    'name' => 'Possible fitment for hills?',
                    'segment_id' => 1,
                    'marks' => 1,
                    'parent_id' => 1

                ],

                [
                    'name' => 'Has leadership qualities? (if relevant)',
                    'segment_id' => 2,
                    'marks' => 1

                ],

                [
                    'name' => 'Relevant to ColoredCow',
                    'segment_id' => 2,
                    'marks'=> 1
                ],

                [
                        'name' => 'Won any competition? (if relevant)',
                        'segment_id'=> 2,
                        'marks'=> 1

                ],

            ];
            $evaluationParametersOptions = [
                [
                    'value' => 'Yes',
                    'marks' => '1',
                ],

                [
                    'value' => 'No',
                    'marks' => '-1'
                ],
            ];

            $round = Round::where('name', 'Resume Screening')->first();
            $round->evaluationParameters()->createMany($evaluationParametersList);
            $evaluationParameters = Parameter::all();
            foreach ($evaluationParameters as $evaluationParameter) {
                $evaluationParameter->options()->createMany($evaluationParametersOptions);
            }

            DB::table('hr_evaluation_parameters')
            ->where('id', 2)
            ->update(['parent_option_id' => 1]);
            DB::table('hr_evaluation_parameters')
            ->where('id', 3)
            ->update(['parent_option_id' => 1]);
            DB::table('hr_evaluation_parameters')
            ->where('id', 4)
            ->update(['parent_option_id' => 2]);
            DB::table('hr_evaluation_parameters')
            ->where('id', 5)
            ->update(['parent_option_id' => 2]);
        }
    }
}
