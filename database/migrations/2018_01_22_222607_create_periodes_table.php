<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('demande_id');
            $table->string('nom',50);
            $table->string('lundi',255);
            $table->string('mardi',255);
            $table->string('mercredi',255);
            $table->string('jeudi',255);
            $table->string('vendredi',255);
            $table->string('samedi',255);
            $table->string('dimanche',255);
            $table->integer('action_id');
            $table->integer('etatdemande_id');
            $table->boolean('selected');
            $table->string('motif_annulation',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periodes');
    }
}
