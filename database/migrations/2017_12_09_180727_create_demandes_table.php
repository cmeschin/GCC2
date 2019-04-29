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
            $table->integer('user_id')->unsigned();
            $table->string('prestation',100);
            $table->integer('preference_id');
            $table->string('reference',50);
            $table->date('date_activation');
            $table->mediumText('commentaire')->nullable();
            $table->time('temps_hote',5)->default(0);
            $table->time('temps_service')->default(0);
            $table->string('ticket_itsm',12)->nullable();
            $table->string('motif_annulation',255)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')
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
