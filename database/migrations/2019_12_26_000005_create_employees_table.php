<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'employees';

    /**
     * Run the migrations.
     * @table employees
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('full_name', 100)->nullable();
            $table->timestamp('employment')->nullable();
            $table->decimal('ratio', 3, 2)->nullable();
            $table->unsignedInteger('id_departament');
            $table->unsignedInteger('id_positione');

            $table->index(["id_positione"], 'id_positione_idx');

            $table->index(["id_departament"], 'id_departament_idx');


            $table->foreign('id_positione', 'id_positione_idx')
                ->references('id')->on('positions')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('id_departament', 'id_departament_idx')
                ->references('id')->on('departments')
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
