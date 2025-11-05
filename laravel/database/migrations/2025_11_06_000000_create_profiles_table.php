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
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('auth.users')->onDelete('cascade');
            
            $table->jsonb('contact_info')->nullable()->comment('Stores email, phone, address, etc.');
            $table->jsonb('wallet_addresses')->nullable()->comment('Array of cryptocurrency wallet addresses');
            $table->text('qr_code_url')->nullable()->comment('URL to manually uploaded wallet QR code');
            $table->string('username')->unique()->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar_url')->nullable();
            
            $table->timestamps();
            $table->index('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
