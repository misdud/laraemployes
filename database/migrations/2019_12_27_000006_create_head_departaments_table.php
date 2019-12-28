<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeadDepartamentsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'head_departaments';

    /**
     * Run the migrations.
     * @table head_departaments
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('id_departamentd');
            $table->unsignedInteger('id_employee');

            $table->index(["id_departamentd"], 'id_departamentd_idx');

            $table->index(["id_employee"], 'id_employee_idx');


            $table->foreign('id_departamentd', 'id_departamentd_idx')
                ->references('id')->on('departments')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('id_employee', 'id_employee_idx')
                ->references('id')->on('employees')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
