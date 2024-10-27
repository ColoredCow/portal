<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LegalDocumentsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
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
