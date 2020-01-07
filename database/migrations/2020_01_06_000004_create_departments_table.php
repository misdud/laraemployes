<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'departments';

    /**
     * Run the migrations.
     * @table departments
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 100)->nullable();
            $table->string('name_head_depart', 100)->nullable();
            $table->unsignedInteger('id_deputys');
            $table->unsignedInteger('id_posit_head');

            $table->index(["id_deputys"], 'id_deputys_idx');

            $table->index(["id_posit_head"], 'id_posit_head_idx');


            $table->foreign('id_deputys', 'id_deputys_idx')
                ->references('id')->on('deputys')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('id_posit_head', 'id_posit_head_idx')
                ->references('id')->on('positions')
                ->onDelete('no action')
                ->onUpdate('no action');
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
