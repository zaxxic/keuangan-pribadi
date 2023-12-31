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
    Schema::create('regular_transactions', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->integer('amount');
      $table->string('payment_method')->nullable();
      $table->string('recurring');
      $table->integer('count')->default(1);
      $table->integer('real');
      $table->string('content');
      $table->string('attachment')->nullable();
      $table->date('date');
      $table->text('description', 400);
      $table->foreignUuid('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
      $table->foreignId('category_id')
        ->constrained('categories')
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
    Schema::dropIfExists('regular_transactions');
  }
};
