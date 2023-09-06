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
        Schema::create('recruing_incomes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('amount');
            $table->string('payment_method');
            $table->date('date');
            $table->text('deskripsi', 400);
            $table->string('recruing')->nullable();
            $table->foreignId('user_id')
            ->constrained('users');
            $table->foreignId('income_id')
            ->constrained('incomes');
            $table->foreignId('income_category_id')
                ->constrained('income_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruing_incomes');
    }
};
