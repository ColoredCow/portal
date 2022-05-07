<?php

namespace Modules\LegalDocument\Database\Seeders;

use Illuminate\Database\Seeder;

class LegalDocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LegalDocument::truncate();
        LegalDocument::updateOrCreate([
            'slug' => 'nda',
            'name' => 'NDA',
        ]);
        LegalDocument::updateOrCreate([
            'slug' => 'contracts',
            'name' => 'Contracts',
        ]);
    }
}
