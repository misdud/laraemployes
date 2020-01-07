<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //---------------
        //boot sequence:  1, 2 and etc....
        //---------------

        //default
        //$this->call(UsersTableSeeder::class);

        // 1 first-boot  PositionSeeder
        //$this->call(PositionSeeder::class);

        // 2 second-boot  HeadEnterpriseSeeder
        //$this->call(HeadEnterpriseSeeder::class);

        //3  DirectorSeeder
        //$this->call(DirectorSeeder::class);

        // 4 DeputySeeder
        //$this->call(DeputySeeder::class);

        // 5 DepartmentSeeder
        //$this->call(DepartmentSeeder::class);

        // 6 EmployeSeeder
        //$this->call(EmployeSeeder::class);


        //------------END--------------

        // FOR TEST
        // !!! after edit factory for step 8 HeadDepartEmplSeeder //
        //$this->call(HeaDepEmpSeeder::class);

        // 7 HeadDepartamentSeeder
        //$this->call(HeadDepartamentSeeder::class);

        // 8 !!! befor edit seeder on 50000
        // and factory set: id_position 10-22  EmployeSeeder
        //$this->call(EmployeSeeder::class);


    }
}
