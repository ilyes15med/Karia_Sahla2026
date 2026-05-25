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
        Schema::create('politiqueAnnulations', function (Blueprint $table) {    
            $table->id();  
            $table->string('type_anullation');
            $table->integer('nombre_jour')->nullable();
            $table->integer('pourcentage_recuperation')->nullable();
            $table->foreignId('Hebergs_id')->constrained()->onDelete('cascade');
       
            $table->timestamps();
        }   ); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('politiqueAnnulations');
    }
};
