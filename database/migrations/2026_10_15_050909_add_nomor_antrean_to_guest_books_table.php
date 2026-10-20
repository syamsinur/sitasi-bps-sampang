<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('guest_books', 'nomor_antrean')) {
            Schema::table('guest_books', function (Blueprint $table) {
                $table->string('nomor_antrean', 20)
                    ->nullable()
                    ->first();
            });
        } else {
            DB::statement("
                ALTER TABLE guest_books
                MODIFY COLUMN nomor_antrean VARCHAR(20)
                NULL FIRST
            ");
        }
    }

    public function down(): void
    {
        Schema::table('guest_books', function (Blueprint $table) {
            $table->dropColumn('nomor_antrean');
        });
    }
};