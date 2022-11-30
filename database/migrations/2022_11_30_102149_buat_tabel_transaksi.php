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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id');
            $table->decimal('nominal', 18, 2);
            $table->tinyInteger('status');
            $table->string('keterangan');
            $table->timestamps();

            $table->foreign('anggota_id')->on('anggota')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::drop('transaksi');
    }
};
