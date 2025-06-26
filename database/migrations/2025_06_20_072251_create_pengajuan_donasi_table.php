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
        Schema::create('pengajuan_donasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('judul_pengajuan', 100);
            $table->text('deskripsi')->nullable();
            $table->string('bukti')->nullable();
            $table->decimal('target_pengajuan', 15, 2);
            $table->enum('status_pengajuan', ['diajukan', 'disetujui', 'ditolak'])->default('diajukan');
            $table->timestamp('tanggal_pengajuan')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_donasi');
    }
};
