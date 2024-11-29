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
        Schema::create('tasks', function (Blueprint $table) {

            $table->id();
        
            $table->string('title'); // Título de la tarea
        
            $table->text('description'); // Descripción de la tarea
        
            $table->boolean('completed')->default(false); // Si está completada o no
        
            $table->unsignedBigInteger('user_id'); // Relación con el usuario que creó la tarea
        
            $table->timestamps();
        
        
        
            // Establecer la relación de llave foránea con la tabla de usuarios
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
