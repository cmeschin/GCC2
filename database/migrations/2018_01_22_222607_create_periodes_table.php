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
            $table->string('tp_name',50);
            $table->string('tp_monday',255);
            $table->string('tp_tuesday',255);
            $table->string('tp_wednesday',255);
            $table->string('tp_thursday',255);
            $table->string('tp_friday',255);
            $table->string('tp_saturday',255);
            $table->string('tp_sunday',255);
            $table->integer('action_id');
            $table->integer('etatdemande_id');
            $table->boolean('selected');
            $table->string('motif_annulation',255);
            $table->timestamps();
            $table->softDeletes();
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
