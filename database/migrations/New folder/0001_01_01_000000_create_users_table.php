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
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->foreignId('convene_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->string('city')->nullable();
            $table->string('language_s')->nullable();
            $table->string('birth')->nullable();
            $table->string('gender_s')->nullable();
            $table->string('married')->nullable();
            $table->string('job_s')->nullable();
            $table->string('education_s')->nullable();
            $table->string('mobile')->nullable();
            $table->string('religion_s')->nullable();
            $table->string('religion')->nullable();
            $table->string('opinion_s')->nullable();
            $table->string('manageable')->nullable();
            $table->string('doAct')->nullable();
            $table->string('relation')->nullable();
            $table->string('situation_s')->nullable();
            $table->string('donation_s')->nullable();
            $table->string('about')->nullable();
            $table->string('character')->nullable();
            $table->string('skill')->nullable();
            $table->string('allergy')->nullable();
            $table->string('other')->nullable();
            $table->string('lastLogin')->nullable();
            $table->string('owner_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
