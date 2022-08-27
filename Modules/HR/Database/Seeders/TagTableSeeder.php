<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            'in-progress' => '#ffed4a',
           'need-follow-up' => '#0000FF',
           'awaiting-confirmation' => '#63B2B7',
            'new-application' => '#38c172',
           'no-show'=> '#FF0000',
           'no-show-reminded' => '#FF0000',
        ];

        if (! app()->environment('production')) {
            $hrStatus = config('hr.tags');
            foreach ($hrStatus as $key=>$status) {
                Tag::updateOrCreate([
                    'slug' => $key,
                    'name' => $status,
                    'background_color' => $colors[$key]
                 ]);
            }
        }
    }
}
