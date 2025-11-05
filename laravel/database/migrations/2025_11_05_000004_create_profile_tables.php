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
        // User Profiles Table
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone_number')->nullable();
            $table->text('bio')->nullable();
            $table->json('social_media_links')->nullable(); // Twitter, LinkedIn, Instagram, etc.
            $table->string('profile_url')->unique();
            $table->timestamps();
        });

        // Wallet Addresses Table
        Schema::create('wallet_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('wallet_type'); // 'bitcoin', 'ethereum', etc.
            $table->string('address');
            $table->timestamps();
            
            $table->unique(['profile_id', 'wallet_type']);
        });

        // Wallet QR Codes Table
        Schema::create('wallet_qr_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_address_id')->constrained('wallet_addresses')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });

        // Gallery Items Table
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Deleted Users Table (for admin access)
        Schema::create('deleted_user_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_user_id');
            $table->json('user_data'); // All user data stored as JSON
            $table->string('deleted_by')->nullable(); // Admin who deleted or 'user'
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deleted_user_data');
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('wallet_qr_codes');
        Schema::dropIfExists('wallet_addresses');
        Schema::dropIfExists('profiles');
    }
};
