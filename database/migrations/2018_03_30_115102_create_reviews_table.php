<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('review_id');
            $table->integer('salary_id',false,true)->nullable();
            $table->foreign("salary_id")->references("salary_id")->on("salaries");
            $table->integer('salary_rate',false,true)->nullable();
            $table->integer('career_rate',false,true)->nullable();
            $table->integer('balance_rate',false,true)->nullable();
            $table->integer('culture_rate',false,true)->nullable();
            $table->integer('management_rate',false,true)->nullable();
            $table->string("positive_review",1024)->nullable();
            $table->string("negative_review",1024)->nullable();
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
        Schema::dropIfExists('reviews');
        Schema::enableForeignKeyConstraints();
    }
}
