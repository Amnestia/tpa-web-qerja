<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('company_id');
            $table->string("name");
            $table->string("description");
            $table->string("website");
            $table->string('email');
            $table->string('location');
            $table->string('phone');
            $table->string('image');
            $table->integer("category_id",false,true);
            $table->foreign("category_id")->references("category_id")->on("categories");
            $table->integer("country_id",false,true);
            $table->foreign("country_id")->references("country_id")->on("countries");
            $table->integer("city_id",false,true);
            $table->foreign("city_id")->references("city_id")->on("cities");
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
        Schema::dropIfExists('companies');
        Schema::enableForeignKeyConstraints();
    }
}
