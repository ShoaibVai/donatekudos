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
        Schema::create('archived_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('original_profile_id')->comment('Reference to original profile');
            $table->uuid('user_id');
            
            $table->jsonb('user_data')->comment('Complete profile snapshot at deletion time');
            $table->jsonb('gallery_data')->nullable()->comment('Snapshot of gallery images');
            
            $table->timestamp('deleted_at')->useCurrent();
            $table->timestamp('expires_at')->nullable()->comment('30 days after deletion');
            
            $table->index('user_id');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_profiles');
    }
};
