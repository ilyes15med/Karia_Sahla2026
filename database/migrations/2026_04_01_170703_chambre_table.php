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
            $table->id();//1
            $table->string('typeChambres');//auto apartement
            $table->decimal('prix',20,2);//auto
            $table->integer('Quantite')->default(0);
            $table->integer('nombre_lit')->default(0);
            $table->integer('nombre_chambre')->default(0);
         
            
            $table->longText('Description')->nullable();
            $table->string('services')->nullable(); 


            $table->text('images_chambres')->nullable();
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
