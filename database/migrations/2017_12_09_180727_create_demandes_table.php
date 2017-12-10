<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',['démarrage', 'mise_à_jour']);
            $table->string('prestation',100);
            $table->integer('user_id');
            $table->integer('listediffusion_id');
            $table->string('reference',50);
            $table->integer('etatdemande_id');
            $table->dateTime('date_supervision');
            $table->text('commentaire');
            $table->time('temps_hote');
            $table->time('temps_service');
            $table->integer('ticket_itsm');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('etatdemande_id')->references('id')->on('etat_demandes');
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
        Schema::table('demandes',function(Blueprint,$table) {
            $table->dropForeign('demandes_user_id_foreign');
        });

        Schema::table('demandes',function(Blueprint,$table) {
            $table->dropForeign('demandes_etatdemande_id_foreign');
        });

        Schema::dropIfExists('demandes');
    }
}
