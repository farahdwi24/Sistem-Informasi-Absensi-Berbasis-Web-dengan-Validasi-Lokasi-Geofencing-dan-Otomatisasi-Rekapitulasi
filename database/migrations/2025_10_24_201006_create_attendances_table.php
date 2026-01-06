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
        Schema::create('attendances', function (Blueprint $table) {
           $table->id();
            $table->foreignId('pegawai_id')->constrained('users')->onDelete('cascade'); 
            
            $table->foreignId('lokasi_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->decimal('latitude_masuk', 10, 8)->nullable();
            $table->decimal('longitude_masuk', 11, 8)->nullable();
            $table->enum('status_kehadiran', ['H', 'T', 'S', 'I', 'A', 'CT']);
            $table->enum('status_persetujuan', ['Pending', 'Approved', 'Rejected'])
                  ->default('Approved');
            $table->text('keterangan')->nullable();
            $table->string('file_lampiran')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
