<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\Job;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class HRJobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Job = new Job;
        Model::unguard();
        $faker = Faker::create();
        foreach (range(1, 25) as $index) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('hr_jobs')->insert([
                'id'=> $index,
                'opportunity_id'=> 5,
                'title'=>  $faker->title,
                'description'=> $faker->text,
                'type'=> $faker->sentence(2),
                'domain'=> $faker->text,
                'start_date'=> $faker->date,
                'link'=> 'https=>//coloredcow.com/career/laravel-developer/',
                'end_date'=> $faker->date,
                'facebook_post'=> $faker->text,
                'twitter_post'=> $faker->text,
                'linkedin_post'=> $faker->text,
                'instagram_post'=> $faker->text,
                'created_at'=> $faker->date,
                'updated_at'=> $faker->date,
                'posted_by'=> 8,
                'status'=> $faker->text,
                'deleted_at'=> $faker->date
            ]);
            DB::table('hr_applicants')->insert([
                'id'=> $index,
                'name'=> $faker->name,
                'email'=>  $faker->email,
                'phone'=> $faker->randomDigit,
                'wa_optin_at'=> $faker->sentence(2),
                'linkedin'=> $faker->text,
                'course'=> $faker->text,
                'graduation_year'=> $faker->randomDigit,
                'college'=> $faker->text,
                'created_at'=> $faker->date,
                'updated_at'=> $faker->date,
                'hr_university_id'=> $faker->text,
            ]);
            DB::table('hr_applications')->insert([
                'id'=> $index,
                'hr_applicant_id'=> $index,
                'hr_job_id'=>  $index,
                'status'=> $faker->text,
                'pending_approval_from'=> $faker->date,
                'offer_letter'=> $faker->text,
                'resume'=> $faker->text,
                'autoresponder_subject'=> $faker->text,
                'autoresponder_body'=> $faker->text,
                'created_at'=> $faker->date,
                'updated_at'=> $faker->date
            ]);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        \Artisan::call('mapping-of-jobs-and-hr-rounds');
    }
}
