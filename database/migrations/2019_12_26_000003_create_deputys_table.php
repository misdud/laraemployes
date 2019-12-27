<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeputysTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'deputys';

    /**
     * Run the migrations.
     * @table deputys
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('full_name_deputy', 100)->nullable();
            $table->unsignedInteger('id_positionde');
            $table->unsignedInteger('id_director');

            $table->index(["id_director"], 'id_director_idx');

            $table->index(["id_positionde"], 'id_positionde_idx');


            $table->foreign('id_director', 'id_director_idx')
                ->references('id')->on('directors')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('id_positionde', 'id_positionde_idx')
                ->references('id')->on('positions')
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
