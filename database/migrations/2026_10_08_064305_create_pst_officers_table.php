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
        Schema::create('pst_officers', function (Blueprint $table) {
            $table->id();
            $table->integer('no_urut');
            $table->string('name');
            $table->string('nip');
            $table->foreignId('work_team_id')->constrained()->cascadeOnDelete();
            $table->string('nomor_hp');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pst_officers');
    }
};
