<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('job_id');
            $table->integer('position_id',false,true);
            $table->foreign('position_id')->references('position_id')->on('positions');
            $table->integer('currency_id',false,true);
            $table->foreign("currency_id")->references("currency_id")->on("currencies");
            $table->string('description',1024);
            $table->bigInteger('salary',false,true);
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
        Schema::dropIfExists('jobs');
        Schema::enableForeignKeyConstraints();
    }
}
