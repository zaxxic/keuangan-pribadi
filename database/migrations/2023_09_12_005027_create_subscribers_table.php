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
    Schema::create('subscribers', function (Blueprint $table) {
      $table->id();
      $table->date('expire_date');
      $table->integer('amount');
      $table->string('status');
      $table->foreignUuid('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('subscribers');
  }
};
