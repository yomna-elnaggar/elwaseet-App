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
            $table->string('name',50);
            $table->string('mobile_number')->unique()->nullable();
            $table->string('country_code')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('gender')->nullable();
          	$table->foreignId('country_id')->nullable()->references('id')->on('countries')->onDelete('cascade');
            $table->foreignId('government_id')->nullable()->references('id')->on('governments')->onDelete('cascade');
          	$table->foreignId('state_id')->nullable()->references('id')->on('states')->onDelete('cascade');
            $table->string('image')->default('upload/user/user.svg');
            $table->date('birth_date')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('mobile_verify_code')->nullable();
            $table->tinyInteger('mobile_attempts_left')->default(0);
            $table->timestamp('mobile_last_attempt_date')->nullable();
            $table->timestamp('mobile_verify_code_sent_at')->nullable();
            $table->string('password')->nullable();
            $table->integer('favorite')->default(0);
            $table->string('social_id')->nullable();
            $table->string('reset_token')->nullable();
            $table->timestamp('reset_token_expiry')->nullable();
          
            $table->rememberToken();
            $table->timestamps();
          
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
