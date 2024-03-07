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
            // $table->string('checksheet_supplier')->default('Ada');
            $table->date('supply_date');
            $table->string('aql_number');
            $table->string('inspection_level');
            $table->mediumInteger('jumlah_kirim');
            // $table->mediumInteger('jumlah_sample');
            // $table->mediumInteger('jumlah_cek')->default(1);
            $table->boolean('status_pengecekan')->default(0);
            // $table->date('tanggal_periksa')->nullable();
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
