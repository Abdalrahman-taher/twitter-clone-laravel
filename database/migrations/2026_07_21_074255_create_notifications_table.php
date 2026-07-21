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
        Schema::create('notifications', function (Blueprint $table) {

            $table->id();

            // =====================================================
            // User who receives the notification
            // =====================================================

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // =====================================================
            // User who performed the action
            // =====================================================

            $table->foreignId('actor_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // =====================================================
            // Related tweet (nullable)
            // Used for likes, comments and retweets
            // =====================================================

            $table->foreignId('tweet_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // =====================================================
            // Notification type
            // follow | like | comment | retweet
            // =====================================================

            $table->string('type');

            // =====================================================
            // Read status
            // =====================================================

            $table->boolean('is_read')
                ->default(false);

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
