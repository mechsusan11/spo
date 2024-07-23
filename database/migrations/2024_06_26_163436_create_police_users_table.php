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
        Schema::create('police_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('mobile');
            $table->unsignedBigInteger('sub_division');
            $table->foreign('sub_division')->references('id')->on('sub_division_master')->onDelete('cascade');
            $table->string('password');
            $table->json('ip_address');
            $table->rememberToken();
            $table->enum('role', ['sp', 'dsp'])->default('dsp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('police_users');
    }
};
