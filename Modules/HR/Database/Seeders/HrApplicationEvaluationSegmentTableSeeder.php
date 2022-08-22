<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HR\Entities\Evaluation\Segment;
use Modules\HR\Entities\Round;

class HrApplicationEvaluationSegmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $segmentNames = $this->getSegmentNames();
        foreach ($segmentNames as $segmentName) {
            Segment::updateOrCreate([
            'name' => $segmentName,
            'round_id'=> Round::first()->id,
        ]);
        }
    }
    private function getSegmentNames()
    {
        return [
            'Resume feeling',
            'Academic achievements',
            'Experience',
            'Projects',
            'CodeTrek',
            'CodeTrek eligibility',
            'General Information',
            'Telephonic Interview Segment',
            'testings',
            'Test segment',
        ];
    }
}
