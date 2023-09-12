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
    Schema::create('saving_member', function (Blueprint $table) {
      $table->id();
      $table->integer('role_id')->unsigned();
      $table->foreignUuid('user_id')->on('users')
        ->onDelete('cascade');
      $table->foreignId('saving_id')->on('savings')
        ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('saving_member');
  }
};
