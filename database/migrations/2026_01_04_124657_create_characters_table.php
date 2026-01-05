<?php

use App\Models\CharacterSpecie;
use App\Models\Stat;
use App\Models\User;
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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();

            // FK.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('character_spacie_id')->constrained()->onDelete('cascade');
            $table->foreignId('stats_id')->constrained()->onDelete('cascade');

            $table->string('pseudo');  // pseudo of the character.
            $table->int('xp')->default(0);  // xp cumul of a perso.
            $table->int('level')->default(1);  // level of character.
            
            $table->boolean('is_selected')->default(false);  // define wish character is used for fight.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('characters', function(Blueprint $table){
            $table->dropForeignIdFor(User::class);
        });
        Schema::table('characters', function(Blueprint $table){
            $table->dropForeignIdFor(CharacterSpecie::class);
        });
        Schema::table('characters', function(Blueprint $table){
            $table->dropForeignIdFor(Stat::class);
        });
        Schema::dropIfExists('characters');
    }
};
