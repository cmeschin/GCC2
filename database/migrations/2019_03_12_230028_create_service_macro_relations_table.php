<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceMacroRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_macro_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_id')->unsigned();
            $table->integer('macro_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('service_id')->references('id')->on('services')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('macro_id')->references('id')->on('macros')
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
        Schema::dropIfExists('service_macro_relations');
    }
}
