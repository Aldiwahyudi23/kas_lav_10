<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tanggal');
            $table->integer('jumlah');
            $table->text('alasan');
            $table->text('sekertaris')->nullable();
            $table->text('bendahara')->nullable();
            $table->text('ketua')->nullable();
            $table->text('status')->nullable();
            $table->foreignId('anggaran_id')->references('id')->on('anggarans');
            $table->foreignId('anggota_id')->references('id')->on('users')->nullable();
            $table->foreignId('keluarga_id')->nullable();
            $table->foreignId('pengurus_id')->references('id')->on('users')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
