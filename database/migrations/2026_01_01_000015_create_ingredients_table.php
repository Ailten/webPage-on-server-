<?php

use App\Models\Craft;
use App\Models\ItemRef;
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
        Schema::create('ingredients', function (Blueprint $table) {
            //$table->id();  // no need PK.

            // FK.
            $table->foreignId('craft_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_ref_id')->constrained()->onDelete('cascade');

            $table->integer('quantity')->default(1);  // quantity of this ingredient need for this craft.

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredients', function(Blueprint $table){
            $table->dropForeignIdFor(Craft::class);
        });
        Schema::table('ingredients', function(Blueprint $table){
            $table->dropForeignIdFor(ItemRef::class);
        });
        Schema::dropIfExists('ingredients');
    }
};
