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
        // Schema::create('tbl_pengecekan', function (Blueprint $table) {
        //     $table->id('id_pengecekan');
        //     $table->unsignedBigInteger('id_part_in');
        //     $table->foreign('id_part_in')->references('id_part_in')->on('tbl_part_in')->onDelete('cascade');
        //     $table->string('part_status');
        //     $table->timestamps();
        // });
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
