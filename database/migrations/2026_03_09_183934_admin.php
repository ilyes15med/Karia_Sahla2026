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
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
          
            $table->string('email')->unique();
         
            $table->string('password');
           
        });
        DB::table('admin')->insert([
            'email'=>'admin1239@gmail.com',
            'password'=>bcrypt('admin147')


        ]);

    
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('admin');
    }
};
