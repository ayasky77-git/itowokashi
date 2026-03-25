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
        Schema::create('dictionaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users'); //外部キーのuserIDを使用
            $table->string('title');
            $table->string('obi_text')->nullable(); //NULL OK
            $table->string('color_code')->nullable();
            $table->string('invite_code')->unique(); //ユニーク
            $table->json('custom_labels')->nullable();    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictionaries');
    }
};
