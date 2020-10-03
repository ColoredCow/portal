<?php

use Illuminate\Database\Seeder;

class LegalDocumentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
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
