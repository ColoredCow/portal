<?php
namespace Modules\LegalDocument\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

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
