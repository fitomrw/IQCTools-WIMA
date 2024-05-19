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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id_supplier')->on('supplier')->onDelete('cascade');
            $table->string('attention', 100);
            $table->string('cc', 100);
            $table->string('part_code');
            $table->foreign('part_code')->references('kode_part')->on('part')->onDelete('cascade');
            $table->unsignedBigInteger('model');
            $table->foreign('model')->references('id_kategori')->on('kategori_part')->onDelete('cascade');
            $table->integer('quantity');
            $table->string('problem_description');
            $table->string('request');
            $table->string('found_area', 60);
            $table->string('found_date', 50);
            $table->string('issue_date', 50);
            $table->unsignedBigInteger('pic_person');
            $table->foreign('pic_person')->references('id')->on('users')->onDelete('cascade');
            $table->integer('status')->default(0);
            $table->string('gambar_lpp');
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
        Schema::dropIfExists('laporan');
    }
};
