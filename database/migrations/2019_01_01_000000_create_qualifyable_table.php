<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualifyableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualifyables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quality_id')->unsigned();
            $table->bigInteger('qualifyable_id')->unsigned();
            $table->string('qualifyable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qualifyables');
    }
}
