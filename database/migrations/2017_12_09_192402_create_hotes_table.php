<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('centreonhost_id')->nullable();
            $table->string('nom',30);
            $table->string('description',255);
            $table->string('ip',50);
            $table->boolean('actif');
            $table->multiLineString('commentaire');
            $table->text('consigne');
            $table->integer('typeaction_id');
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
        Schema::dropIfExists('hotes');
    }
}
