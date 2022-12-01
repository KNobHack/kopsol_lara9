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
        Schema::create('tunggakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id');
            $table->string('nama_tunggakan');
            $table->decimal('nominal', 18, 2);
            $table->text('keterangan');
            $table->tinyInteger('status');

            $table->bigInteger('tertunggak_id');
            $table->string('tertunggak_type');

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
        Schema::drop('tunggakan');
    }
};
