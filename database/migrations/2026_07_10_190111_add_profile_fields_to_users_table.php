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
        Schema::table('users', function (Blueprint $table) {
            // Unique so we can later use it as a profile handle (like @username)
            $table->string('username')->nullable()->unique()->after('name');

            $table->text('bio')->nullable();
            $table->string('location')->nullable();
            $table->string('website')->nullable();

            // These store the file path returned by Storage, not the image itself
            $table->string('avatar')->nullable();
            $table->string('cover')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'bio',
                'location',
                'website',
                'avatar',
                'cover',
            ]);
        });
    }
};
