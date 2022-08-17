<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;
use Google\Service\Compute\Tags;

class TagTableTableSeeder extends Seeder
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
