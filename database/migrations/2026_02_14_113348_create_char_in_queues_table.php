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
        Schema::create('char_in_queues', function (Blueprint $table) {
            //$table->id();  // no need PK.

            // FK.
            $table->foreignId('bot_twitch_id')->constrained()->onDelete('cascade');
            $table->foreignId('char_in_queue_id')->constrained()->onDelete('cascade');

            $table->boolean('selected')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('char_in_queues');
    }
};
