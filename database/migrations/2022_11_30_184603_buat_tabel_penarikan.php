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
        Schema::create('penarikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggota', 'id');
            $table->foreignId('transaksi_id')->constrained('transaksi', 'id');

            $table->tinyInteger('jenis');
            $table->bigInteger('nominal');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('penarikan');
    }
};
