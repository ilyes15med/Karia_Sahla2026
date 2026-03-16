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
        //
    Schema::create('Hebergs', function (Blueprint $table) {    
        $table->id();
        $table->string('nomHeberg');
        $table->string('typeHeberg');
        $table->longText('Description');
        $table->string('service');
        $table->string('nombre_lit');
        $table->string('nombre_chambre');
        $table->string('status');
        $table->string('addresse');
        $table->decimal('latitude',10,7);
        $table->decimal('longitude',10,7);
        $table->string('images');
        $table->foreignId('users_id')->constrained();
        $table->timestamps();
    }   ); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('Hebergs');
    }
};
