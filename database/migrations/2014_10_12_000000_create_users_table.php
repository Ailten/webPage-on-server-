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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();  // pseudo twitch (use as FK to match twitch connection OAuth).
            $table->integer('xp')->default(0);  // need a function to cast xp as level (stock in user obj for nor re-calculate).
            $table->integer('gold')->default(0);  // money in game.
            $table->integer('gemme')->default(0);  // money ++.
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
