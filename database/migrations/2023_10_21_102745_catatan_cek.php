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
        Schema::create('catatan_cek', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_part_supply');
            $table->foreign('id_part_supply')->references('id_part_supply')->on('tbl_part_in')->onDelete('cascade');
            $table->unsignedBigInteger('id_standar_part');
            $table->foreign('id_standar_part')->references('id_standar_part')->on('standar_part')->onDelete('cascade');
            $table->string('status')->nullable();
            $table->string('checksheet')->nullable();
            $table->integer('urutan_sample')->nullable();
            $table->string('final_status')->nullable();
            $table->integer('value_dimensi')->nullable();
            $table->date('tanggal_cek')->nullable();
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
