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

            $table->integer('twitch_id')->unique();  // id twitch acount (to match OAuth connection).
            $table->longText('twitch_access_token');  // token twitch.
            $table->longText('twitch_refresh_token');  // token to renouvelle token twitch.
            $table->string('twitch_email')->unique();  // email from twitch acount (only use to recuperation acount).
            $table->string('twitch_pseudo');  // pseudo twitch.  ->  get from obj twitch User, no need to be stocked.

            //$table->integer('xp')->default(0);  // need a function to cast xp as level (stock in user obj for nor re-calculate).
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
