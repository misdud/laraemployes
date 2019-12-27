<?php

use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert([
            [
                'name_position'=>'Генеральный директор',
                'salary_position'=>4000
            ],
            [
                'name_position'=>'Директор',
                'salary_position'=>3500
            ],
            [
                'name_position'=>'Заместитель директора по производству',
                'salary_position'=>3000
            ],
            [
                'name_position'=>'Заместитель директора по экономике',
                'salary_position'=>3000
            ],
            [
                'name_position'=>'Заместитель директора по кадрам',
                'salary_position'=>3000
            ],
            [
                'name_position'=>'Заместитель директора по логистике',
                'salary_position'=>3000
            ],
            [
                'name_position'=>'Заместитель директора по МТО',
                'salary_position'=>3000
            ],
            [
                'name_position'=>'Заместитель директора по соц. вопросам',
                'salary_position'=>3000
            ],
            [
                'name_position'=>'Начальник отдела',
                'salary_position'=>2500
            ],
            [
                'name_position'=>'Инженер-программист',
                'salary_position'=>2000
            ],
            [
                'name_position'=>'Инжерер-электрик',
                'salary_position'=>2000
            ],
            [
                'name_position'=>'Инженер-наладчик',
                'salary_position'=>2000
            ],
            [
                'name_position'=>'Инженер-системотехник',
                'salary_position'=>2000
            ],
            [
                'name_position'=>'Системный архитектор',
                'salary_position'=>2000
            ],
            [
                'name_position'=>'Тестировщик',
                'salary_position'=>2000
            ],
            [
                'name_position'=>'Специалист',
                'salary_position'=>2000
            ],
            [
                'name_position'=>'Технический писатель',
                'salary_position'=>2000
            ],
            [
                'name_position'=>'Системный аналитик',
                'salary_position'=>2000
            ],
            [
                'name_position'=>'Системный аналитик',
                'salary_position'=>2000
            ],
            [
                'name_position'=>'Инженер',
                'salary_position'=>1500
            ],
            [
                'name_position'=>'Экономист',
                'salary_position'=>1500
            ],
            [
                'name_position'=>'Инспектор по кадрам',
                'salary_position'=>1500
            ],

        ]);

    }
}
