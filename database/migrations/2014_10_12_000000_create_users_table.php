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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname_p');
            $table->string('lastname_m');
            $table->integer('age');
            $table->date('birthdate');
            $table->string('email')->unique();
            $table->string('phone', 20)->unique();
            $table->timestamp('email_verified_at')->nullable(); // * autogenerada
            $table->string('password');
            $table->boolean('active')->default(false);
            $table->double('latitude');
            $table->double('longitude');
            $table->rememberToken(); // * autogenerado (quizá relacionado a personal access y password reset)
            $table->timestamps(); // * autogenerado
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
