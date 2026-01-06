<?php

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
        Schema::create('xp_need_per_levels', function (Blueprint $table) {
            //$table->id();  // no need PK.

            $table->tinyInteger('level')->unsigned()->unique();  // level of the character, when he want to lvl up.
            $table->integer('xp_need');  // xp need to level up.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xp_need_per_levels');
    }
};
