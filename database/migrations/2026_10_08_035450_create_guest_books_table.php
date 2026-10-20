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
        Schema::create('guest_books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('instansi');
            $table->string('keperluan');
            $table->string('detail_keperluan');
            $table->string('no_hp');
            $table->string('petugas')->nullable();
            $table->text('catatan_konsultasi')->nullable();
            $table->string('dokumentasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_books');
    }
};
