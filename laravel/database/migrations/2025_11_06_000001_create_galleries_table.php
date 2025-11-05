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
        Schema::create('galleries', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('profile_id');
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
            
            $table->text('image_url')->comment('URL to uploaded image');
            $table->string('filename')->nullable();
            $table->integer('file_size')->nullable();
            $table->string('mime_type')->nullable();
            
            $table->timestamps();
            $table->index('profile_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
