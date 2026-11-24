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
        Schema::create('queue_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pst_officer_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->string('keperluan')->index();
            $table->text('comment')->nullable();
            $table->timestamps();
            // Cegah 1 record buku tamu memberi rating lebih dari sekali
            $table->unique('guest_book_id');
            // Mempercepat hitung rata-rata bintang per petugas
            $table->index('pst_officer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_ratings');
    }
};
