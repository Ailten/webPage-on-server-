<?php

use App\Models\CharacterSpecie;
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

            // TODO : verify if I can delete Factories and seeders (and verify what use for Factories), and if after deleting I need to delete some line from other file php who can call it.

            // FK.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('character_spacie_id')->constrained()->onDelete('cascade');
            //$table->foreignId('stats_id');  // TODO : stock in the model, not in DB (re-calculate when get from DB, create, or switch an equipement).

            $table->string('pseudo');  // pseudo of the character.
            $table->int('xp')->default(0);  // xp cumul of a perso,
            //$table->int('level');  // calculate based on xp, not stocked.
            
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
        Schema::dropIfExists('characters');
    }
};
