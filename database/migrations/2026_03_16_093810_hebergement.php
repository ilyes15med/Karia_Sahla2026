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
        $table->decimal('prix',20,2);
        $table->longText('Description');
        $table->string('service');
       
        $table->integer('nombre_chambre')->default(0);
        $table->string('status');
        $table->string('addresse');
        $table->decimal('latitude',20,15);
        $table->decimal('longitude',20,15);
        $table->text('images');
        $table->text('conditions')->nullable();
        $table->foreignId('users_id')->constrained();//hote
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
