<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email');
            $table->string('password')->nullable();
            $table->timestamp('lastconnection');
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->rememberToken();
            $table->timestamps(); // définit les champs created_at et updated_at de manière automatique
            $table->softDeletes();
//            $table->foreign('id')->references('user_id')->on('demandes')
//                ->onDelete('restrict');
//            $table->foreign('id')->references('user_id')->on('preferences')
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
        Schema::dropIfExists('users');
    }
}
