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
        Schema::create('chambres', function (Blueprint $table) {    
            $table->id();
            $table->string('typeChambres');
            $table->decimal('prix',20,2);
            $table->longText('Description');
            $table->string('services');
            $table->string('code_promo')->nullable();
            $table->decimal('pourcentage_codepromo',5,2)->nullable();

            $table->integer('nombre_lit')->default(0);
            $table->integer('nombre_chambre')->default(0);
            $table->decimal('taxe',5,2);
            $table->decimal('anullation',5,2);
            $table->string('payment');
            $table->text('images_chambres');
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
        Schema::dropIfExists('chambres');
    }
};
