<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create profiles table
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_url')->unique();
            $table->string('bitcoin_address')->nullable();
            $table->string('ethereum_address')->nullable();
            $table->json('other_addresses')->nullable();
            $table->json('social_media')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('profile_url');
        });

        // Create wallet_qr_codes table
        Schema::create('wallet_qr_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->string('cryptocurrency_type')->default('bitcoin');
            $table->timestamps();

            $table->index('profile_id');
        });

        // Create gallery_items table
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();

            $table->index('profile_id');
        });

        // Create deleted_users table
        Schema::create('deleted_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_user_id');
            $table->json('user_data');
            $table->timestamp('deleted_at');
            $table->unsignedBigInteger('deleted_by')->nullable();
            
            $table->index('original_user_id');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deleted_users');
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('wallet_qr_codes');
        Schema::dropIfExists('profiles');
    }
};
