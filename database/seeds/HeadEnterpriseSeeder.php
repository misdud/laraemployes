<?php

use Illuminate\Database\Seeder;

class HeadEnterpriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('head_enterptises')->insert([
           'full_name_head' =>'Иванов Иван Иванович',
           'id_position' =>1
       ]);
    }
}
