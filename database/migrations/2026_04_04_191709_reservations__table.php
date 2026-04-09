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
        Schema::create('reservations', function (Blueprint $table) {    
            $table->id();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->boolean('canEval')->default(0);
            $table->string('nom_complet');
            $table->string('idCarteNational');
            $table->boolean('CanCancel')->default(1);
            $table->string('addresse');
            $table->string('NumTelephone');
            $table->foreignId('users_id')->constrained()->onDelete('cascade');
            $table->foreignId('chambres_id')->constrained()->onDelete('cascade');
         //   $table->foreignId('paiment_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        }   ); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('reservations');
    }
};
