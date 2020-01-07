<?php

use App\Employe;
use Illuminate\Database\Seeder;

class HeaDepEmpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Employe::class, 200)->create();
    }
}