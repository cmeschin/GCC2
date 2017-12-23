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
            $table->integer('typedemande_id');
            $table->integer('etatdemande_id');
            $table->integer('user_id');
            $table->string('prestation',100);
            $table->integer('listediffusion_id');
            $table->string('reference',50);
            $table->dateTime('date_activation');
            $table->text('commentaire');
            $table->time('temps_hote');
            $table->time('temps_service');
            $table->string('ticket_itsm',12);
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
//        Schema::table('demandes',function(Blueprint $table) {
//            $table->dropForeign('demandes_user_id_foreign');
//        });
//
//        Schema::table('demandes',function(Blueprint $table) {
//            $table->dropForeign('demandes_etatdemande_id_foreign');
//        });

        Schema::dropIfExists('demandes');
    }
}
