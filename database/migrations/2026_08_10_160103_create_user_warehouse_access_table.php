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
        Schema::create('erp_user_warehouse_access', function (Blueprint $table) {
            $table->foreignUuid('user_id')
                ->constrained('erp_users')
                ->cascadeOnDelete();

            $table->foreignUuid('warehouse_id')
                ->constrained('erp_warehouses')
                ->cascadeOnDelete();

            $table->timestampsTz();

            $table->primary(['user_id', 'warehouse_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('erp_user_warehouse_access');
    }
};
