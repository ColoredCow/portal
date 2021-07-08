<?php

namespace Modules\LegalDocument\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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

        \DB::table('legal_documents')->insert(array(
            0 =>
            array(
                'slug' => 'nda',
                'name' => 'NDA',
            ),
            1 =>
            array(
                'slug' => 'contracts',
                'name' => 'Contracts',
            ),
        ));
    }
}
