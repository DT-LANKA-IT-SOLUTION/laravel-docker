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
        Schema::create('erp_roles', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('tenant_id')
                ->constrained('erp_tenants')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();

            $table->boolean('status')->default(true);
            $table->boolean('is_system')->default(false);

            $table->timestampsTz();

            $table->unique(['tenant_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('erp_roles');
    }
};
