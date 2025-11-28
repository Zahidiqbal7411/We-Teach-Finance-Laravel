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
        Schema::create('acc_transaction_payouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('selected_currency');
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('teacher_id');

            // must match teachers.id type
            $table->decimal('paid_amount', 10, 2);
            $table->string('type', 255);
            $table->string('remarks', 255);


            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade'); // must match transactions.id type
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('selected_currency')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('acc_transactions')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_transaction_payouts');
    }
};
