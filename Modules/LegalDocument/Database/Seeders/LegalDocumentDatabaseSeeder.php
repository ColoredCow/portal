<?php

namespace Modules\LegalDocument\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LegalDocumentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(LegalDocumentsTableSeeder::class);
        $this->call(LegalDocumentPermissionsTableSeeder::class);
    }
}
