<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoteFonctionRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hote_fonction_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hote_id')-> unsigned();
            $table->integer('hotefonction_id')-> unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('hote_id')->references('id')->on('hotes')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('hotefonction_id')->references('id')->on('hote_fonctions')
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
        Schema::dropIfExists('hote_fonction_relations');
    }
}
