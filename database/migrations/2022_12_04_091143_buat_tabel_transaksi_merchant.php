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
        Schema::create('transaksi_merchant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id');
            $table->foreignId('produk_id');

            $table->smallInteger('jumlah_beli');
            $table->decimal('total_nominal', 18, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('transaksi_id')->on('transaksi')->references('id');
            $table->foreign('produk_id')->on('produk')->references('id');
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
