<?php

use App\Models\ItemRef;
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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();

            // FK.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_ref_id')->constrained()->onDelete('cascade');
            $table->foreignId('stat_id')->nullable()->default(null)->constrained()->onDelete('cascade');

            $table->integer('quantity')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function(Blueprint $table){
            $table->dropForeignIdFor(User::class);
        });
        Schema::table('inventories', function(Blueprint $table){
            $table->dropForeignIdFor(ItemRef::class);
        });
        Schema::table('inventories', function(Blueprint $table){
            $table->dropForeignIdFor(Stat::class);
        });
        Schema::dropIfExists('inventories');
    }
};
