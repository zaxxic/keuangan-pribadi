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
    Schema::create('history_savings', function (Blueprint $table) {
      $table->id();
      $table->foreignId('saving_id')->on('savings')->constrained()
        ->onDelete('cascade');
      $table->foreignId('history_transaction_id')->constrained()->onDelete('cascade');
      $table->timestamps();
      $table->unique(['history_transaction_id', 'saving_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('history_savings');
  }
};
