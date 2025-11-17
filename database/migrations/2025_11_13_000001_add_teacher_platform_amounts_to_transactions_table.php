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
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'teacher_amount')) {
                $table->decimal('teacher_amount', 10, 2)->nullable()->after('paid_amount');
            }
            if (!Schema::hasColumn('transactions', 'platform_amount')) {
                $table->decimal('platform_amount', 10, 2)->nullable()->after('teacher_amount');
            }
            if (!Schema::hasColumn('transactions', 'teacher_percent')) {
                $table->decimal('teacher_percent', 5, 2)->nullable()->after('platform_amount');
            }
            if (!Schema::hasColumn('transactions', 'platform_percent')) {
                $table->decimal('platform_percent', 5, 2)->nullable()->after('teacher_percent');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'platform_percent')) {
                $table->dropColumn('platform_percent');
            }
            if (Schema::hasColumn('transactions', 'teacher_percent')) {
                $table->dropColumn('teacher_percent');
            }
            if (Schema::hasColumn('transactions', 'platform_amount')) {
                $table->dropColumn('platform_amount');
            }
            if (Schema::hasColumn('transactions', 'teacher_amount')) {
                $table->dropColumn('teacher_amount');
            }
        });
    }
};
