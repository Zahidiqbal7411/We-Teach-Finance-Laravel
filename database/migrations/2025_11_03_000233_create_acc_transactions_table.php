<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acc_transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('session_id');

            $table->string('student_name');
            $table->string('student_contact')->nullable();
            $table->string('student_email')->nullable();
            $table->string('parent_name')->nullable();

            $table->integer('course_fee')->nullable();
            $table->integer('note_fee')->nullable();

            $table->decimal('total', 10, 2);
            $table->decimal('paid_amount', 10, 2);

            $table->unsignedBigInteger('selected_currency')->default(0);

            $table->bigInteger('platform_amount')->nullable();
            $table->bigInteger('teacher_amount')->nullable();

            $table->unsignedBigInteger('express_course_id')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('selected_currency')
                ->references('id')->on('currencies')
                ->onDelete('cascade');

            $table->foreign('teacher_id')
                ->references('id')->on('teachers')
                ->onDelete('cascade');

            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onDelete('cascade');

            $table->foreign('session_id')
                ->references('id')->on('acc_taxonomies_sessions')
                ->onDelete('cascade');

            $table->foreign('express_course_id')
                ->references('id')->on('express_courses')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acc_transactions');
    }
};
