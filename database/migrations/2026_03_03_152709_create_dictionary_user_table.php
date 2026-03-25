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
        Schema::create('dictionary_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dictionary_id')->constrained('dictionaries'); //外部キー
            $table->foreignId('user_id')->constrained('users'); //外部キー
            $table->unique(['dictionary_id', 'user_id']);
            $table->string('nickname')->nullable();
            $table->timestamp('last_accessed_at')->nullable();
            $table->enum('role', ['admin', 'editor', 'viewer'])->default('editor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictionary_user');
    }
};
