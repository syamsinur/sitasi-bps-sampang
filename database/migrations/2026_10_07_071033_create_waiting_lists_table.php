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
        Schema::create('waiting_lists', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique()->nullable();
            $table->string('nomor_antrean', 20)->nullable();
            $table->string('name');
            $table->string('instansi');
            $table->string('keperluan');
            $table->string('detail_keperluan');
            $table->string('keperluan_lainnya')->nullable();
            $table->string('no_hp');
            $table->string('petugas')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waiting_lists');
    }
};
