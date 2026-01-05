<?php

use App\Models\ItemCategorie;
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
            $table->foreignId('item_categories_id')->constrained()->onDelete('cascade');

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
        Schema::dropIfExists('item_refs');
    }
};
