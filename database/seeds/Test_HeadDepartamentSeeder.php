<?php

use Illuminate\Database\Seeder;

class HeadDepartamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\HeadDepartament::class, 200)->create();
    }
}
