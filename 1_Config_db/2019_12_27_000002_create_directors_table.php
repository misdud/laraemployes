<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectorsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'directors';

    /**
     * Run the migrations.
     * @table directors
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('full_name_director', 100)->nullable();
            $table->unsignedInteger('id_positiond');
            $table->unsignedInteger('id_head');

            $table->index(["id_head"], 'id_head_idx');

            $table->index(["id_positiond"], 'id_positiond_idx');


            $table->foreign('id_positiond', 'id_positiond_idx')
                ->references('id')->on('positions')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('id_head', 'id_head_idx')
                ->references('id')->on('head_enterptises')
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
