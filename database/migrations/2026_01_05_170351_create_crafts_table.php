<?php

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
        Schema::create('crafts', function (Blueprint $table) {
            $table->id();

            // FK.
            $table->foreignId('item_ref_id')->constrained()->onDelete('cascade');  // item result of craft.

            $table->int('quantity')->default(1);  // quantity of item generate when craft make.
            $table->float('rate');  // success rate of craft work (1.0 = 100%).

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crafts', function(Blueprint $table){
            $table->dropForeignIdFor(ItemRef::class);
        });
        Schema::dropIfExists('crafts');
    }
};
