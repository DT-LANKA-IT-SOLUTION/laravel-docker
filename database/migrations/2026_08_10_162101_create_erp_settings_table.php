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
        Schema::create('erp_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();

            /*
             * Scope
             *
             * System  : tenant_id = NULL, company_id = NULL,
             *           branch_id = NULL, user_id = NULL
             *
             * Tenant  : tenant_id
             *
             * Company : tenant_id + company_id
             *
             * Branch  : tenant_id + company_id + branch_id
             *
             * User    : tenant_id + user_id
             */

            $table->foreignUuid('tenant_id')
                ->nullable()
                ->constrained('erp_tenants')
                ->cascadeOnDelete();

            $table->foreignUuid('company_id')
                ->nullable()
                ->constrained('erp_companies')
                ->cascadeOnDelete();

            $table->foreignUuid('branch_id')
                ->nullable()
                ->constrained('erp_branches')
                ->cascadeOnDelete();

            $table->foreignUuid('user_id')
                ->nullable()
                ->constrained('erp_users')
                ->cascadeOnDelete();

            $table->string('key', 150);

            $table->text('value')->nullable();

            $table->string('value_type', 20)->default('string');

            $table->string('description')->nullable();
            $table->boolean('is_encrypted')->default(false);

            $table->timestampsTz();

            /*
             * Indexes for scoped lookups.
             */
            $table->index(['tenant_id', 'key']);
            $table->index(['company_id', 'key']);
            $table->index(['branch_id', 'key']);
            $table->index(['user_id', 'key']);
        });

        /*
         * Prevent invalid scope combinations.
         *
         * System:
         *   no scope IDs
         *
         * Tenant:
         *   tenant only
         *
         * Company:
         *   tenant + company
         *
         * Branch:
         *   tenant + company + branch
         *
         * User:
         *   tenant + user
         */
        DB::statement("
            ALTER TABLE erp_settings
            ADD CONSTRAINT settings_valid_scope_check
            CHECK (
                (
                    tenant_id IS NULL
                    AND company_id IS NULL
                    AND branch_id IS NULL
                    AND user_id IS NULL
                )
                OR
                (
                    tenant_id IS NOT NULL
                    AND company_id IS NULL
                    AND branch_id IS NULL
                    AND user_id IS NULL
                )
                OR
                (
                    tenant_id IS NOT NULL
                    AND company_id IS NOT NULL
                    AND branch_id IS NULL
                    AND user_id IS NULL
                )
                OR
                (
                    tenant_id IS NOT NULL
                    AND company_id IS NOT NULL
                    AND branch_id IS NOT NULL
                    AND user_id IS NULL
                )
                OR
                (
                    tenant_id IS NOT NULL
                    AND company_id IS NULL
                    AND branch_id IS NULL
                    AND user_id IS NOT NULL
                )
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('erp_settings');
    }
};
