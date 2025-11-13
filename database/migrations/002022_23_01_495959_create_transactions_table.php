<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Foreign keys (using foreignId for consistency and automatic unsignedBigInteger)
            $table->foreignId('teacher_id')
                  ->constrained('teachers')
                  ->cascadeOnDelete();

            $table->foreignId('course_id')
                  ->constrained('courses')
                  ->cascadeOnDelete();

            $table->foreignId('session_id')
                  ->constrained('sessions')
                  ->cascadeOnDelete();

            $table->foreignId('selected_currency')
                  ->constrained('currencies')
                  ->cascadeOnDelete();

            // Other columns
            $table->string('student_name');
            $table->string('parent_name');
            $table->decimal('total', 10, 2);
            $table->decimal('paid_amount', 10, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
