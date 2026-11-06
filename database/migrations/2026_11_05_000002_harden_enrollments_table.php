<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Endurece `enrollments`: agrega quién registra la inscripción, evita
     * pares estudiante/club repetidos y hace que las FK borren en cascada.
     */
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->foreignId('registered_by')
                ->nullable()
                ->after('status')
                ->constrained('users')
                ->nullOnDelete();
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['club_id']);
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->cascadeOnDelete();

            $table->foreign('club_id')
                ->references('id')
                ->on('clubs')
                ->cascadeOnDelete();

            $table->unique(['student_id', 'club_id']);
        });
    }

    /**
     * Revierte exactamente lo agregado en up().
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropUnique(['student_id', 'club_id']);
            $table->dropForeign(['student_id']);
            $table->dropForeign(['club_id']);
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('club_id')->references('id')->on('clubs');
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropForeign(['registered_by']);
            $table->dropColumn('registered_by');
        });
    }
};
