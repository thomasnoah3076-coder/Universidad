<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // PK (id_evento)
            
            $table->string('name'); // nombre_evento
            $table->text('description')->nullable(); // descripcion
            $table->dateTime('event_date'); // fecha_evento
            $table->string('location')->nullable(); // lugar
            $table->integer('max_capacity')->nullable(); // cupo_maximo
            $table->boolean('status')->default(true); // activo
            $table ->foreignId('registered_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete(); // FK (id_usuario_registro) hacia la tabla users
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};