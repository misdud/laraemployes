<?php


use Illuminate\Database\Seeder;

class EmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\Employe::class, 50000)->create();
        factory(App\Employe::class, 10000)->create();
    }
}
