<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tp_name',200)->index();
            $table->string('tp_monday',2048)->nullable();
            $table->string('tp_tuesday',2048)->nullable();
            $table->string('tp_wednesday',2048)->nullable();
            $table->string('tp_thursday',2048)->nullable();
            $table->string('tp_friday',2048)->nullable();
            $table->string('tp_saturday',2048)->nullable();
            $table->string('tp_sunday',2048)->nullable();
            $table->integer('demande_id')->nullable();
            $table->integer('action_id')->nullable();
            $table->integer('etatdemande_id')->nullable();
            $table->boolean('selected')->default(false);
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
        Schema::dropIfExists('periodes');
    }
}
