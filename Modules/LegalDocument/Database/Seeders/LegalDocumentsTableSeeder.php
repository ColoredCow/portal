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
        \DB::table('legal_documents')->delete();

        \DB::table('legal_documents')->insert([
            0 => [
                'slug' => 'nda',
                'name' => 'NDA',
            ],
            1 => [
                'slug' => 'contracts',
                'name' => 'Contracts',
            ],
        ]);
    }
}
