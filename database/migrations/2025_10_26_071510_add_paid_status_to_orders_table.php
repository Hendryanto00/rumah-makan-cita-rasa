<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify enum to include 'paid' status
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'diproses', 'selesai', 'batal') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'diproses', 'selesai', 'batal') DEFAULT 'pending'");
    }
};
