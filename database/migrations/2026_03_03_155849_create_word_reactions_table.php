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
        Schema::create('word_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_id')->constrained('words'); //外部キー
            $table->foreignId('user_id')->constrained('users'); //外部キー
            $table->enum('scope', ['community', 'public'])->default('community');
            $table->date('reacted_on');
            $table->unique(['word_id','user_id', 'reacted_on']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_reactionstable');
    }
};
