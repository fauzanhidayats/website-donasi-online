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
        Schema::create('donasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();
            $table->foreignId('pengajuan_id')->nullable()->constrained('pengajuan_donasi')->nullOnDelete();
            $table->decimal('jumlah_donasi', 15, 2);
            $table->dateTime('tanggal_donasi')->useCurrent();
            $table->enum('status_pembayaran', ['pending', 'berhasil', 'gagal'])->default('pending');
            $table->string('nama_donatur', 100)->nullable();
            $table->string('email_donatur', 100)->nullable();
            $table->string('no_hp_donatur', 20)->nullable();
            $table->string('metode_pembayaran', 50)->nullable();
            $table->string('kode_transaksi_gateway', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasi');
    }
};
