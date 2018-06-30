<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name')->nullable();
            $table->string('city')->nullable();
            $table->string('vacancy')->nullable();
            $table->string('vacancy_level')->nullable();
            $table->string('technoligy')->nullable();
            $table->integer('questions_amount')->nullable();
            $table->string('complexity_level')->nullable();
            $table->string('test_time')->nullable();
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
