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
        $statuses = config('hr.status');
        foreach ($statuses as $status) {
            Tag::updateOrCreate([
                'slug' => $status['label'],
                'name' => $status['title'],
            ]);
        }
    }
}
