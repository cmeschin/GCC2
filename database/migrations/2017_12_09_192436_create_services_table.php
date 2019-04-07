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
            $table->integer('demande_id');
            $table->integer('hote_id');
            $table->integer('centreonhost_id')->nullable();
            $table->integer('centreonservice_id')->nullable();
            $table->integer('modeleservice_id');
            $table->integer('centreonservicetemplate_id')->nullable();
            $table->string('nom',255);
            $table->text('parametres');
            $table->integer('periode_id');
            $table->string('frequence',25);
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
        Schema::dropIfExists('services');
    }
}
