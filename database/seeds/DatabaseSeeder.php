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
        //boot sequence:  1, 2 and ....
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
         // $this->call(EmployeSeeder::class);

        // 7 HeadDepartamentSeeder
          $this->call(HeadDepartamentSeeder::class);
    }
}
