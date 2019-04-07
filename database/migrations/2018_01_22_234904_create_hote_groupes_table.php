<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoteGroupesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hote_groupes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('centreon_hg_id');
            $table->string('groupe',50);
            $table->string('nom',50);
            $table->string('abreviation',5)->nullable(); // nullable() rend optionnel la saisie de ce champ
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
        Schema::dropIfExists('hote_groupes');
    }
}
