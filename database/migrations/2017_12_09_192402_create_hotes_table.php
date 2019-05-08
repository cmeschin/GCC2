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
            $table->integer('demande_id');
            $table->integer('centreon_host_id')->nullable();
            $table->string('centreon_host_name',200);
            $table->string('nom',30);
            $table->string('description',200);
            $table->string('ip',255);
            $table->boolean('actif');
            $table->multiLineString('commentaire');
            $table->text('consigne');
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
        Schema::dropIfExists('hotes');
    }
}
