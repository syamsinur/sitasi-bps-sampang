<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE guest_books
            MODIFY COLUMN keperluan_lainnya VARCHAR(255)
            NULL AFTER detail_keperluan
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE guest_books
            MODIFY COLUMN keperluan_lainnya VARCHAR(255)
            NULL
        ");
    }
};