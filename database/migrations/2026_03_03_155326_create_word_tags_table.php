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
        Schema::create('word_tag', function (Blueprint $table) {
            $table->foreignId('word_id')->constrained('words'); //外部キー
            $table->foreignId('tag_id')->constrained('tags'); //外部キー
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_tags');
    }
};
