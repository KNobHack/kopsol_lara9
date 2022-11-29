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
        Schema::table('users', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->foreignId('role_id')->after('id');
                $table->string('nik', 16)->unique();
                $table->string('nama');
                $table->string('tempat_lahir');
                $table->date('tanggal_lahir');
                $table->enum('agama', [
                    'Islam', 'Kristen', 'Katholik',
                    'Hindu', 'Budha', 'Konghucu'
                ]);
                $table->string('pekerjaan');
                $table->text('alamat');
                $table->string('nomor_telpon', 15);

                $table->foreign('role_id')->on('roles')->references('id');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
};
