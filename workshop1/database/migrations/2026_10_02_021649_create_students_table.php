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
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Student name
            $table->string('email')->unique(); // Unique email
            $table->string('phone'); // Phone number
            $table->text('address')->nullable(); // Optional address
            $table->date('date_of_birth')->nullable(); // Optional DOB
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

