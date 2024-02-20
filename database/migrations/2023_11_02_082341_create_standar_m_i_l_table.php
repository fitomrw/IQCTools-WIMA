<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mil_std_105_e', function (Blueprint $table) {
            $table->id();
            $table->integer('min_sample');
            $table->integer('max_sample');
            $table->string('size_code');
            $table->integer('sample_size');
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
        Schema::dropIfExists('mil_std_105_e');
    }
};
