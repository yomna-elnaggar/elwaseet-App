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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->nullable()->references('id')->on('categories')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->references('id')->on('sub_categories')->onDelete('cascade');
          	$table->foreignId('government_id')->nullable()->references('id')->on('governments')->onDelete('cascade');
          	$table->foreignId('state_id')->nullable()->references('id')->on('states')->onDelete('cascade');
            $table->string('mobile_number'); 
            $table->string('whatsApp_number')->nullable(); 
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->string('selling_price')->nullable();
            $table->integer('views')->default(0); 
            $table->integer('payment_method')->default(0);
            $table->integer('sell_or_rent')->default(0); 
            $table->integer('Negotiable')->default(0);//قابل للتفاوض
            $table->integer('favorite')->default(0); 
            $table->integer('salled_or_not')->default(0); 
            $table->integer('Contact_by_phone')->default(0); 
            $table->integer('Contact_by_whatsapp')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
