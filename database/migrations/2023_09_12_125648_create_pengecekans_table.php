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
        Schema::create('tbl_pengecekan', function (Blueprint $table) {
            $table->id('id_pengecekan');
            $table->string('kode_part');
            $table->foreign('kode_part')->references('kode_part')->on('part')->onDelete('cascade');
            $table->string('nama_part');
            $table->dateTime('supply_date', $precision = 0);
            $table->string('titik_check');
            $table->string('check_standard');
            $table->string('tool');
            $table->string('part_status');
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
        Schema::dropIfExists('pengecekans');
    }
};
