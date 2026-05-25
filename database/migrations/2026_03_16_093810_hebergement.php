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
        $table->id();  //1
        $table->string('nomHeberg');//appartement f3 de ilyes
        $table->string('typeHeberg');//appartement
        $table->decimal('prix',20,2);//prix
        $table->longText('Description');//
        $table->string('service'); //
        $table->integer('nombre_lit')->default(0);
        $table->integer('nombre_chambre')->default(0);//automtique 3
        $table->string('code_promo')->nullable();
        $table->decimal('pourcentage_codepromo',5,2)->nullable();
        $table->string('status');//acceprt ,refuse
        $table->decimal('montant_taxe_sejour',10,2)->default(0);
        $table->string('addresse');
        $table->decimal('latitude',20,15);
        $table->decimal('longitude',20,15);
        $table->text('images');
        $table->string('payment_method');
        $table->text('politiqueHeb')->nullable();
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
