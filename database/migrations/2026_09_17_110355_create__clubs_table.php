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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id(); // PK (id_club)
            
            $table->string('name')->unique(); // nombre_club (UK)
            $table->text('description')->nullable(); // descripcion
            $table->date('foundation_date')->nullable(); // fecha_fundacion
            $table->boolean('status')->default(true);
            // FK (id_presidente) hacia la tabla students
            $table->foreignId('president_id')
                    ->nullable()
                    ->constrained('students')
                    ->nullOnDelete(); 
            $table ->foreignId('registered_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete(); // FK (id_usuario_registro) hacia la tabla users
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};