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
        if (! app()->environment('production')) {
            $hrStatus = config('hr.status');
            foreach ($hrStatus as $status) {
                Tag::updateOrCreate([
                    'slug' => $status['label'],
                    'name' => $status['title'],
                ]);
            }
        }
    }
}
