<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\University;

class AddUniversityIdToApplicantsTableTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $applicants = Applicant::all();
        $universities = University::all();

        foreach ($applicants as $applicant) {
            $university = $this->findUniversity($applicant, $universities);

            if (!$university) {
                continue;
            }

            $applicant->update(['hr_university_id' => $university->id]);
        }
    }

    private function findUniversity($applicant, $universities) {
        $key = $universities->search(function ($university) use ($applicant) {
            return strtolower($university->name) === strtolower($applicant->college);
        });

        return $key ? $universities[$key] : false;
    }
}
