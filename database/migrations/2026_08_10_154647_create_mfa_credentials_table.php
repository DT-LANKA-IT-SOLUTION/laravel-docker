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
        Schema::create('erp_mfa_credentials', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')
                ->constrained('erp_users')
                ->cascadeOnDelete();

            $table->string('type');
            $table->text('secret');

            $table->boolean('enabled')->default(false);
            $table->timestampTz('verified_at')->nullable();

            $table->timestampTz('last_used_at')->nullable();

            $table->timestampsTz();

            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('erp_mfa_credentials');
    }
};
