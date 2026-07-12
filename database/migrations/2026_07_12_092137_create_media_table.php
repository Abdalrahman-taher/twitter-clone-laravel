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
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            // Polymorphic relation:
            // Allows this media file to belong to any model (User, Tweet, etc.)
            $table->morphs('mediable');

            // Describes the purpose of the file
            // Examples: avatar, cover, tweet
            $table->string('collection');

            // Stores the file path returned by Laravel Storage
            $table->string('path');

            // Stores the real MIME type of the uploaded file
            // Examples: image/jpeg, image/png, video/mp4
            $table->string('mime_type');

            // File size in bytes
            $table->unsignedBigInteger('size');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
