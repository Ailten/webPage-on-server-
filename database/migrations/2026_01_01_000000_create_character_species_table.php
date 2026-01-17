<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    insert into character_species (`name`) 
    values('Mercenaire'),('Tank'),('Soigneur'); 
    */

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('character_species', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();  // libele.
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_species');
    }
};
