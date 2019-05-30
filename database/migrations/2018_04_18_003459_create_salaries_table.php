<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('salaries', function (Blueprint $table) {
            $table->increments('salary_id');
            $table->integer('company_id',false,true);
            $table->foreign("company_id")->references("company_id")->on("companies");
            $table->integer('position_id',false,true);
            $table->foreign("position_id")->references("position_id")->on("positions");
            $table->integer('salary_period_id',false,true);
            $table->foreign("salary_period_id")->references("salary_period_id")->on("salary_periods");
            $table->integer('period_id',false,true);
            $table->foreign("period_id")->references("period_id")->on("periods");
            $table->integer('currency_id',false,true);
            $table->foreign("currency_id")->references("currency_id")->on("currencies");
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
        Schema::dropIfExists('salaries');
        Schema::enableForeignKeyConstraints();
    }
}
