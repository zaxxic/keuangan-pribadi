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
    Schema::create('regular_savings', function (Blueprint $table) {
      $table->id();
      $table->integer('amount');
      $table->string('payment_method')->nullable();
      $table->string('recurring');
      $table->date('date');
      $table->foreignId('saving_id')->constrained()->on('savings')
        ->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('regular_savings');
  }
};
