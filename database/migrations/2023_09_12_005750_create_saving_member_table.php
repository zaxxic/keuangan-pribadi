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
    Schema::create('saving_members', function (Blueprint $table) {
      $table->id();
      $table->foreignUuid('user_id')->constrained()->on('users')
        ->onDelete('cascade');
      $table->foreignId('saving_id')->constrained()->on('savings')
        ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('saving_members');
  }
};
