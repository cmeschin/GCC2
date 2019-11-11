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
            $table->integer('centreon_service_id')->nullable();
            $table->integer('centreon_service_template_id')->nullable();
            $table->string('nom',255);
            $table->text('parametres')->nullable();
            $table->string('tp_name',200);
            $table->string('frequence',25);
            $table->boolean('actif');
            $table->multiLineString('commentaire')->nullable();
            $table->text('consigne')->nullable();
            $table->integer('action_id')->nullable();
            $table->integer('etatdemande_id')->nullable();
            $table->boolean('selected')->default(false);
            $table->timestamps();
            $table->softDeletes();
//            $table->foreign('id')->references('service_id')->on('macros')
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
        Schema::dropIfExists('services');
    }
}
