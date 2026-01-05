<?php

use App\Models\ItemCategorie;
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
        Schema::create('item_refs', function (Blueprint $table) {
            $table->id();

            // FK.
            $table->foreignId('item_categorie_id')->constrained()->onDelete('cascade');
            $table->foreignId('stat_id')->nullable()->default(null)->constrained()->onDelete('cascade');

            $table->string('name')->unique();  // libele.  
            $table->int('price');  // price reference for trade to pnj/shop.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_refs', function(Blueprint $table){
            $table->dropForeignIdFor(ItemCategorie::class);
        });
        Schema::table('item_refs', function(Blueprint $table){
            $table->dropForeignIdFor(Stat::class);
        });
        Schema::dropIfExists('item_refs');
    }
};
