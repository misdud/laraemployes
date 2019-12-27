<?php

use Illuminate\Database\Seeder;

class DeputySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Deputy::class, 30)->create();
    }
}
