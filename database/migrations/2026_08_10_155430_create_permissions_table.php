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
        Schema::create('erp_permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('module_id')
                ->constrained('erp_modules')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();

            $table->timestampsTz();

            $table->index('module_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('erp_permissions');
    }
};
