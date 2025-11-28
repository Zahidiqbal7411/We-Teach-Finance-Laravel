<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('acc_transactions', function (Blueprint $table) {
            $table->decimal('course_fee', 10, 2)->after('paid_amount')->nullable();
            $table->decimal('note_fee', 10, 2)->after('course_fee')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('acc_transactions', function (Blueprint $table) {
            $table->dropColumn(['course_fee', 'note_fee']);
        });
    }
};
