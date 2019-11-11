<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMacrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('macros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_id')->unsigned();
            $table->string('macro_name',255);
            $table->string('macro_value',4096);
            $table->string('macro_value_old',4096);
            $table->tinyInteger('is_password');
            $table->text('description');
            $table->string('source',255);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('service_id')->references('id')->on('services')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('macros');
    }
}
