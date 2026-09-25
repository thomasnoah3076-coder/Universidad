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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id(); // PK (id_inscripcion)
            
            // FKs (id_estudiante y id_club)
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('club_id')->constrained('clubs');
            $table->dateTime('enrollment_date')->useCurrent(); // fecha_inscripcion
            
            // Estado manejado con opciones predefinidas
            $table->enum('status', ['pending', 'active', 'rejected', 'inactive'])->default('pending'); // estado
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};