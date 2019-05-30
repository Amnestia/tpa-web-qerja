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
        Schema::disableForeignKeyConstraints();
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string("name");
            $table->string("email")->unique();
            $table->string("password");
            $table->tinyInteger("verified")->default(0);
            $table->string("verification_code")->nullable();
            $table->integer("role_id",false,true)->default(2);
            $table->foreign("role_id")->references("role_id")->on("roles");
            $table->string('profile_picture')->default("no_image.png");
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();
    }
}
