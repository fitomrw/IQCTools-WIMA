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
        Schema::create('standar_part', function (Blueprint $table) {
            $table->id('id_standar_part');
            $table->string('kode_part');
            $table->foreign('kode_part')->references('kode_part')->on('part')->onDelete('cascade');
            $table->unsignedBigInteger('id_standar');
            $table->foreign('id_standar')->references('id_standar')->on('standar')->onDelete('cascade');
            $table->string('rincian_standar');
            $table->string('spesifikasi');
            $table->string('point');
            $table->string('max')->nullable();
            $table->string('min')->nullable();
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
        //
    }
};
