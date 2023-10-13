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
        Schema::create('tbl_part_in', function (Blueprint $table) {
            $table->id('id_part_supply');
            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')->references('id_kategori')->on('kategori_part')->onDelete('cascade');
            $table->string('kode_part');
            $table->foreign('kode_part')->references('kode_part')->on('part')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id_supplier')->on('supplier')->onDelete('cascade');
            $table->string('checksheet_supplier');
            $table->dateTime('supply_date', $precision = 0);
            $table->mediumInteger('jumlah_kirim');
            $table->mediumInteger('jumlah_cek');
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
        Schema::dropIfExists('tbl_part_in');
    }
};
