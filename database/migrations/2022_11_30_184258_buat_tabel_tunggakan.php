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
            $table->string('nama_tunggakan');
            $table->decimal('nominal', 18, 2);
            $table->text('keterangan')->nullable();
            $table->tinyInteger('status');

            $table->bigInteger('tertunggak_id')->nullable();
            $table->string('tertunggak_type')->nullable();

            $table->bigInteger('penunggak_id')->nullable();
            $table->string('penunggak_type')->nullable();

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
        Schema::drop('tunggakan');
    }
};
