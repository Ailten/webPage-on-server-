<?php

use App\Models\Stat;
use App\Models\StatType;
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
        Schema::create('stat_type_values', function (Blueprint $table) {
            //$table->id();  // no need PK.
            
            // FK.
            $table->foreignId('stat_id')->constrained()->onDelete('cascade');
            $table->foreignId('stat_type_id')->constrained()->onDelete('cascade');

            $table->integer('value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stat_type_values', function(Blueprint $table){
            $table->dropForeignIdFor(Stat::class);
        });
        Schema::table('stat_type_values', function(Blueprint $table){
            $table->dropForeignIdFor(StatType::class);
        });
        Schema::dropIfExists('stat_type_values');
    }
};
