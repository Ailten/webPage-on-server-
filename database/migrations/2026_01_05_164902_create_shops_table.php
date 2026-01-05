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
        Schema::create('shops', function (Blueprint $table) {
            //$table->id();  // no need PK (until whant to an Historic trade with Character).

            // FK.
            $table->foreignId('item_ref_id')->constrained()->onDelete('cascade');

            $table->timestamp('start_sell_date');  // date when start sell in shop (crop on years).
            $table->timestamp('end_sell_date');  // date when stop sell in shop (crop on years).
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shops', function(Blueprint $table){
            $table->dropForeignIdFor(ItemRef::class);
        });
        Schema::dropIfExists('shops');
    }
};
