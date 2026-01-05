<?php

use App\Models\Character;
use App\Models\Inventory;
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
        Schema::create('equipeds', function (Blueprint $table) {
            $table->id();
            
            // FK.
            $table->foreignId('character_id')->constrained()->onDelete('cascade');
            $table->foreignId('inventory_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipeds', function(Blueprint $table){
            $table->dropForeignIdFor(Character::class);
        });
        Schema::table('equipeds', function(Blueprint $table){
            $table->dropForeignIdFor(Inventory::class);
        });
        Schema::dropIfExists('equipeds');
    }
};
