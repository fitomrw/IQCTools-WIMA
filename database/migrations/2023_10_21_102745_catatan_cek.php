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
            $table->string('status',10)->nullable();
            $table->string('checksheet', 10)->nullable();
            $table->integer('urutan_sample')->nullable();
            $table->string('final_status', 10)->nullable();
            $table->string('value_dimensi', 10)->nullable();
            $table->date('tanggal_cek')->nullable();
            $table->timestamps();
            $table->string('id_part');
            $table->foreign('id_part')->references('kode_part')->on('part')->onDelete('cascade');
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
