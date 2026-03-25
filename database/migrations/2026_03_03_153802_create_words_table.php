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
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dictionary_id')->constrained('dictionaries'); //外部キー
            $table->foreignId('user_id')->constrained('users'); //外部キー
            $table->foreignId('last_editor_id')->constrained('users')->nullable(); //外部キー
            $table->string('headword');
            $table->string('reading');
            $table->string('initial_char');
            $table->text('raw_episode');
            $table->json('dictionary_data');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->string('image_path')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};
