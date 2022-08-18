<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class HRDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
    {
		Model::unguard();
        $this->call(HRPermissionsTableSeeder::class);
		$this->call(HRRoundsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(HRJobsSeederTableSeeder::class);
        $this->call(AddPreparatoryRoundsSeeder::class);
        $this->call(HrApplicantsTableSeeder::class);
        $this->call(HrApplicationsTableSeeder::class);
        $this->call(HrApplicationRoundTableSeeder::class);
        $this->call(HrChannelsTableSeeder::class);
        $this->call(HrDomainTableSeeder::class);
        $this->call(ResumeScreeningEvaluationSeeder::class);
        $this->call(ApplicationEvaluationTableSeeder::class);
        $this->call(HrApplicationMetaTableSeeder::class);
        $this->call(HrApplicationRejectionReasonTableSeeder::class);
        $this->call(HrApplicationRoundReviewTableSeeder::class);
        $this->call(HrApplicationEvaluationSegmentTableSeeder::class);
        $this->call(HrApplicationSegmentTableSeeder::class);
        $this->call(HrUniversitiesTableSeeder::class);
        $this->call(HrUniversitiesContactsTableSeeder::class);
        $this->call(HrUniversityAliasesTableSeeder::class);
        $this->call(HrResourcesCategoriesTableSeeder::class);
        $this->call(HrResourcesTableSeeder::class);
        $this->call(HrFollowUpTableSeeder::class);
        $this->call(TagTableSeeder::class);
    }
}
