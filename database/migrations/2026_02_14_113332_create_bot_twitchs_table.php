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
        Schema::create('bot_twitchs', function (Blueprint $table) {
            //$table->id();  // no need PK : get by only one match to FK User.

            // FK.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('cmdJoin')->default('!join {pseudo}');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_twitchs');
    }
};
