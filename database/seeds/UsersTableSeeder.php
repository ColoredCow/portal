<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {




        \DB::table('users')->insert(array(

            0 =>
            array(
                'email' => 'shamoon@coloredcow.in',
                'id' => 4,
                'name' => 'Mohd Shamoon',
                'password' => '$2y$10$CXInRf/1N0zoD6jlZvBb5.b4lN.nfAU1vx/pvySLvhsqW/AivGkZ6',
                'provider' => 'google',
                'provider_id' => '110082244484400105088',
            ),

        ));
    }
}
