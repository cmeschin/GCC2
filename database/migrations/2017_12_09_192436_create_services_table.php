<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('centreonhost_id')->nullable();
            $table->integer('centreonservice_id')->nullable();
            $table->integer('servicemodele_id');
            $table->integer('centreonservicetemplate_id');
            $table->string('nom',255);
            $table->text('parametres');
            $table->integer('periode_id');
            $table->string('frequence',25);
            $table->boolean('actif');
            $table->multiLineString('commentaire');
            $table->string('consigne');
            $table->integer('typeaction_id');
            $table->integer('etatdemande_id');
            $table->boolean('selected');
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
        Schema::dropIfExists('services');
    }
}
