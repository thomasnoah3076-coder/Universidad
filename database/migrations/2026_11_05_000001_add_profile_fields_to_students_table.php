<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega a students los datos que el flujo de registro de estudiante
     * necesita para vincular el usuario autenticable y guardar la fotografía.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->unique()
                ->after('id')
                ->constrained('users')
                ->nullOnDelete();

            $table->string('numerodocumento')
                ->nullable()
                ->unique()
                ->after('email');

            $table->string('image')
                ->nullable()
                ->after('degree_program');
        });
    }

    /**
     * Revierte exactamente las columnas agregadas en up().
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropUnique(['user_id']);
            $table->dropUnique(['numerodocumento']);
            $table->dropColumn(['user_id', 'numerodocumento', 'image']);
        });
    }
};
