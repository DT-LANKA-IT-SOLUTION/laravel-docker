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
        Schema::create('erp_password_reset_tokens', function (Blueprint $table) {
            $table->foreignUuid('tenant_id')
                ->constrained('erp_tenants')
                ->cascadeOnDelete();

            $table->string('email');
            $table->string('token');
            $table->timestampTz('created_at')->nullable();

            $table->primary(['tenant_id', 'email']);

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('erp_password_reset_tokens');
    }
};
