<?php

use App\Models\ItemRef;
use App\Models\Mob;
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
        Schema::create('loots', function (Blueprint $table) {
            //$table->id();  // no need PK.

            // FK.
            $table->foreignId('mob_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_ref_id')->constrained()->onDelete('cascade');

            $table->float('rate');  // 1.0 equal a loot rate of 100%.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loots', function(Blueprint $table){
            $table->dropForeignIdFor(Mob::class);
        });
        Schema::table('loots', function(Blueprint $table){
            $table->dropForeignIdFor(ItemRef::class);
        });
        Schema::dropIfExists('loots');
    }
};
