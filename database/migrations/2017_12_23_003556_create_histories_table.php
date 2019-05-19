<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->integer('demande_id')->nullable()->index();
            $table->integer('hote_id')->nullable()->index();
            $table->integer('service_id')->nullable()->index();
            $table->integer('periode_id')->nullable()->index();
            $table->integer('etatdemande_id')->nullable()->index();
            $table->string('motif_annulation',255)->nullable();
            $table->text('commentaire')->nullable();
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
        Schema::dropIfExists('histories');
    }
}
