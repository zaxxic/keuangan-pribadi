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
    Schema::create('recurring_expenditures', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->integer('amount');
      $table->string('payment_method')->nullable();
      $table->string('recurring')->nullable();
      $table->integer('count');
      $table->date('date');
      $table->text('description', 400);
      $table->foreignUuid('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
      $table->foreignId('expenditure_category_id')
        ->constrained('expenditure_categories')
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
    Schema::dropIfExists('recurring_expenditures');
  }
};
