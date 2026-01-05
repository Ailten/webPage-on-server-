<?php

use App\Models\Stat;
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
        Schema::create('mobs', function (Blueprint $table) {
            $table->id();

            // FK.
            $table->foreignId('stat_id')->constrained()->onDelete('cascade');

            $table->string('name')->unique();  // libele.
            $table->int('level');  // level of mob.
            $table->int('xp_given');  // xp give when killed.

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mobs', function(Blueprint $table){
            $table->dropForeignIdFor(Stat::class);
        });
        Schema::dropIfExists('mobs');
    }
};
