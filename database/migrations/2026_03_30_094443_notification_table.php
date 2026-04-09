<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();              // مهم
            $table->string('type');                     // مهم
            $table->morphs('notifiable');              // notifiable_id (ili tawssalah notification)+ type
            $table->text('data');                       // JSON data
            $table->timestamp('read_at')->nullable();   // مهم
            $table->timestamps();                       // created_at + updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};