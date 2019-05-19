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
            $table->string('centreon_host_name',200)->nullable();
            $table->string('nom',30);
            $table->string('description',200);
            $table->string('ip',255);
            $table->string('site',255);
            $table->string('solution',255)->nullable();
            $table->string('type',255)->nullable();
            $table->string('os',255)->nullable();
            $table->boolean('actif');
            $table->multiLineString('commentaire')->nullable();
            $table->text('consigne')->nullable();
            $table->integer('action_id')->nullable();
            $table->integer('etatdemande_id')->nullable();
            $table->boolean('selected')->default(false);
            $table->timestamps();
            $table->softDeletes();
//            $table->foreign('id')->references('hote_id')->on('fonctions')
//                ->onDelete('cascade');
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
