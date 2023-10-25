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
    Schema::create('subscriber_transactions', function (Blueprint $table) {
      $table->id();
      $table->integer('amount');
      $table->string('status');
      $table->string('reference');
      $table->string('merchant_ref');
      $table->foreignUuid('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
      $table->foreignId('package_id')->constrained()->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('subscriber_transactions');
  }
};
